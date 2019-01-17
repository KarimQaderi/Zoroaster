<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;

    class Form extends ViewAbstract
    {


        /**
         * element کلاس
         *
         * @var string
         */
        private $class;

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        private $action;
        private $method;
        private $method_PUT;


        /**
         * ایجاد
         *
         * @param string $action
         * @param string $method
         * @param bool $method_PUT
         * @param array $fields
         * @param string $class
         */
        public function __construct($action , $method = 'POST' , $method_PUT = false , $fields  , $class = null)
        {
            $this->action = $action;
            $this->method  = $method ;
            $this->method_PUT  = $method_PUT ;
            $this->data  = $fields ;
            $this->class = $class;
        }

        /**
         *
         *
         * @param string $action
         * @param string $method
         * @param bool $method_PUT
         * @param array $fields
         * @param string $class
         *
         * @return
         *
         */
        public static function make($action , $method= 'POST'   , $method_PUT = false  , $fields  , $class = null)
        {
            return new static($action , $method  , $method_PUT , $fields  , $class);
        }

        /**
         *  نمایش
         *
         * @return string
         */
        public function render($builder , $field = null , $ResourceRequest = null)
        {
            if($builder->method_PUT)
                $builder->method_PUT = method_field('PUT');

            return "<form class=\"BuilderFields ".$builder->class ."\" 
                          action=\"{$builder->action}\" 
                          method=\"{$builder->method}\">" . csrf_field() . $builder->method_PUT . $builder->data .
                "</form>";

        }


    }