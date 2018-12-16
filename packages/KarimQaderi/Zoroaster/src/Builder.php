<?php


    namespace KarimQaderi\Zoroaster;


    trait  Builder
    {


        /**
         * @param          $builders
         * @param callable $where
         * @param          $viewForm
         * @param          $resource
         *
         * @return null|string
         */
        public static function RenderViewForm($builders , callable $where , $viewForm , $resource , $ResourceRequest = null)
        {
            $renders = null;


            foreach($builders as $builder)
            {

                $render = null;

                if(call_user_func($where , $builder) === true)

                    if(is_string($builder))
                        $render = $builder;

                    elseif(is_object($builder) && class_basename($builder) === 'View')
                        $render = $builder->render();

                    elseif($builder->component == 'MenuItem')
                    {
                        if(is_array($builder->data))
                            $builder->data = self::RenderViewForm($builder->data , $where , $viewForm , $resource , $ResourceRequest);
                        $render = $builder->Render($builder);
                    }


                    elseif($builder->component == 'Menu')
                    {
                        if(is_array($builder->data))
                            $builder->data = self::RenderViewForm($builder->data , $where , $viewForm , $resource , $ResourceRequest);
                        if($builder->canSee)
                            $render = self::call($builder , 'Render' , $builder);
                    }


                    elseif($builder->component == 'view')
                        $render = self::call($builder , 'Render' , $builder);


                    elseif(in_array($builder->component , ['value-metric' , 'trend-metric' , 'partition-metric']))
                    {
                        if($builder->canSee())
                            $render = self::call($builder , 'render' , $builder);
                    }

                    elseif($builder->component == 'field_group')
                    {
                        $render = self::call($builder , 'render' ,
                            $builder , self::RenderViewForm($builder->data , $where , $viewForm , $resource , $ResourceRequest) , $ResourceRequest
                        );
                    }


                    elseif($builder->component == 'field' || $builder->component == 'btn')
                        $render = self::call($builder , $viewForm , $builder , $resource , $ResourceRequest);


                    elseif(isset($builder->data))
                        $render = self::call($builder , $viewForm ,
                            $builder , self::RenderViewForm($builder->data , $where , $viewForm , $resource , $ResourceRequest) , $ResourceRequest
                        );


                $renders .= $render;

            }

            return $renders;
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