<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    abstract class ViewAbstract
    {
        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'view';

        /**
         *  نمایش
         *
         * @return string
         */
        abstract public function render($builder , $field = null, $ResourceRequest = null);

//        /**
//         * عنصر ایجاد
//         *
//         * @return static
//         */
//        public static function make(...$arguments)
//        {
//            return new static(...$arguments);
//        }
    }