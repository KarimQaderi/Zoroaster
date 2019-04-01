<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;

    class Row extends ViewAbstract
    {

        use TraitView;


        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'row';

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        /**
         * عنصر دادهای
         *
         * @var string
         */
        public $class;

        /**
         * ایجاد
         *
         * @param  array $fields
         * @return void
         */
        public function __construct($fields = [], $class = null)
        {
            $this->data = $fields;
            $this->class = $class;
        }

    }
