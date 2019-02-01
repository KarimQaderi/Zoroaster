<?php


    namespace KarimQaderi\Zoroaster\Traits;


    trait  Builder
    {

        public static function RenderForm($fields , $resource = null , $where = null)
        {
            return static::RenderViewForm($fields , $where , 'viewForm' , $resource , null);
        }

        public static function RenderDetail($fields , $resource = null , $where = null)
        {
            return static::RenderViewForm($fields , $where , 'viewDetail' , $resource , null);
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

                if(!is_null($where) && call_user_func($where , $builder) === false) continue;


                if(method_exists($builder , 'authorizedToSee') &&
                    self::call($builder , 'authorizedToSee' , $resource) === false)
                    continue;


                if(isset($builder->data) && is_array($builder->data))
                    $builder->data = self::RenderViewForm($builder->data , $where , $viewForm , $resource , $ResourceRequest);


                if(is_string($builder))
                    $render = $builder;

                elseif(is_null($builder))
                    $render = null;

                elseif(is_array($builder))
                    $render = self::RenderViewForm($builder , $where , $viewForm , $resource , $ResourceRequest);

                elseif(in_array($builder->component , ['view' , 'card']))
                    $render = self::call($builder , 'render' , $builder , $resource , $ResourceRequest);

                elseif($builder->component === 'relationship' && $builder->authorizedToIndex($builder))
                    $render = self::call($builder , $viewForm , $builder , $resource , $ResourceRequest);

                elseif($builder->component === 'resource' && $builder->authorizedToIndex($builder->newModel()))
                    $render = view('Zoroaster::resources.index-ajax')->with(['resource' => $builder]);

                elseif(is_object($builder) && class_basename($builder) === 'View')
                    $render = self::call($builder , 'Render');

                elseif($builder->component == 'MenuItem' || $builder->component == 'Menu')
                    $render = self::call($builder , 'Render' , $builder);

                elseif(in_array($builder->component , ['value-metric' , 'trend-metric' , 'partition-metric']) && $builder->authorizedToSee())
                    $render = self::call($builder , 'render' , $builder);

                elseif($builder->component == 'field_group')
                    $render = self::call($builder , 'render' , $builder , $builder->data , $ResourceRequest);

                elseif($builder->component == 'field' || $builder->component == 'btn')
                    $render = self::call($builder , $viewForm , $builder , $resource , $ResourceRequest);

                elseif(isset($builder->data))
                    $render = self::call($builder , $viewForm , $builder , $builder->data , $ResourceRequest);


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