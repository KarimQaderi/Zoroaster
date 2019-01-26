<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;

    class HtmlElement extends ViewAbstract
    {


        /**
         * element کلاس
         *
         * @var string
         */
        public $class;

        /**
         * ها عنصر
         *
         * @var array
         */
        public $text;

        /**
         * element
         *
         * @var string
         */
        public $element;

        /**
         * ایجاد
         */
        public function __construct($element , $text , $class = null)
        {
            $this->element = $element;
            $this->class = $class;
            $this->text = $text;
        }



        /**
         *  نمایش
         *
         * @return string
         */
        public function render($builder, $field = null, $ResourceRequest = null)
        {
            return "<{$builder->element} class='{$builder->class}'>" . $builder->text . "</{$builder->element}>";
        }

        /**
         * عنصر ایجاد
         *
         * @return static
         */
        public static function make($element , $text , $class = null)
        {
            return new static($element , $text , $class);
        }
    }