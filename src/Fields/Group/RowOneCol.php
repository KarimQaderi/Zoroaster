<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    class RowOneCol extends ViewAbstract
    {

        use TraitView;


        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'RowOneCol';

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        /**
         * ایجاد
         *
         * @param  array $fields
         * @return void
         */
        public function __construct($fields = [])
        {
            $this->data = $fields;
        }


    }