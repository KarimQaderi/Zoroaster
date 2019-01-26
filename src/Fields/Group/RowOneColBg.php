<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;



    class RowOneColBg extends ViewAbstract
    {

        use TraitView;


        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'RowOneColBg';

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        public $class;

        /**
         * ایجاد
         *
         * @param  array $fields
         * @return void
         */
        public function __construct($fields = [] , $class = null)
        {
            $this->class = $class;
            $this->data = $fields;
        }

    }