<?php


    namespace KarimQaderi\Zoroaster\Traits;


    use Illuminate\Contracts\View\View;

    trait  Builder
    {

        public static function RenderForm($fields , $resource = null , $where = null, $ResourceRequest = null)
        {
            return static::RenderViewForm($fields , $where , 'viewForm' , $resource , $ResourceRequest);
        }

        public static function RenderDetail($fields , $resource = null , $where = null, $ResourceRequest = null)
        {
            return static::RenderViewForm($fields , $where , 'viewDetail' , $resource , $ResourceRequest);
        }

        /**
         * @param          $builders
         * @param callable $where
         * @param          $viewForm
         * @param          $resource
         * @return null|string
         */
        public static function RenderViewForm($builders , $where , $viewForm , $resource , $ResourceRequest = null)
        {
            $renders = null;

            foreach($builders as $builder){

                $render = null;

                if(is_object($builder))
                    $builder = clone $builder;

                if(!is_null($where) && call_user_func($where , $builder) === false) continue;

                if(method_exists($builder , 'authorizedToSee') &&
                    static::call($builder , 'authorizedToSee' , $resource) === false)
                    continue;

                if(isset($builder->data) && is_array($builder->data))
                    $builder->data = static::RenderViewForm($builder->data , $where , $viewForm , $resource , $ResourceRequest);

                if(is_string($builder))
                    $render = $builder;

                elseif(is_null($builder))
                    $render = null;

                elseif(is_array($builder))
                    $render = static::RenderViewForm($builder , $where , $viewForm , $resource , $ResourceRequest);

                elseif(in_array($builder->component , ['view' , 'card']))
                    $render = static::call($builder , 'render' , $builder , $resource , $ResourceRequest);

                elseif($builder->component === 'relationship' && $builder->authorizedToIndex($builder))
                    $render = static::call($builder , $viewForm , $builder , $resource , $ResourceRequest);

                elseif($builder->component === 'resource' && $builder->authorizedToIndex($builder->newModel()))
                    $render = view('Zoroaster::resources.index-ajax')->with(['resource' => $builder]);

                elseif($builder instanceof View)
                    $render = static::call($builder , 'Render');

                elseif($builder->component == 'MenuItem' || $builder->component == 'Menu')
                    $render = static::call($builder , 'Render' , $builder);

                elseif(in_array($builder->component , ['value-metric' , 'trend-metric' , 'partition-metric']) && $builder->authorizedToSee())
                    $render = static::call($builder , 'render' , $builder);

                elseif($builder->component == 'field_group')
                    $render = static::call($builder , 'render' , $builder , $builder->data , $ResourceRequest);

                elseif(in_array($builder->component , ['field' , 'btn' , 'repeater']))
                    $render = static::call($builder , $viewForm , $builder , $resource , $ResourceRequest);

                elseif(isset($builder->data))
                    $render = static::call($builder , $viewForm , $builder , $builder->data , $ResourceRequest);


                try{
                    $renders .= $render;
                } catch(\Exception $exception){
                    dd($viewForm);
                }

            }

            return \Zoroaster::minifyHtml($renders);
        }


        /**
         * @param       $class
         * @param       $method
         * @param array $parameters
         *
         * @return mixed
         */
        private static function call($class , $method , ...$parameters)
        {
            return $class->{$method}(...$parameters);
        }


    }