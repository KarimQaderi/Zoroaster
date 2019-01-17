<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;

    use KarimQaderi\Zoroaster\Fields\Extend\Field;

    class Html extends Field
    {
        private $text;

        public $OnCreation = false;
        public $OnUpdate = false;
        /**
         * ایجاد
         */
        public function __construct($text)
        {
            $this->text = $text;
        }

        /**
         *  نمایش
         *
         * @return string
         */
        public function viewDetail($builder , $field = null , $ResourceRequest = null)
        {
            return $this->view($builder , $field = null , $ResourceRequest = null);
        }

        public function viewIndex($builder , $field = null , $ResourceRequest = null)
        {
            return $this->view($builder , $field = null , $ResourceRequest = null);
        }

        public function viewForm($builder , $field = null , $ResourceRequest = null)
        {
            return $this->view($builder , $field = null , $ResourceRequest = null);
        }

        private function view($builder , $field = null , $ResourceRequest = null)
        {
            if(is_callable($builder->text))
                return call_user_func($builder->text , $field , $ResourceRequest);
            else
                return $builder->text;
        }


    }