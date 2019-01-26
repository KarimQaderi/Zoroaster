<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    class Col extends ViewAbstract
    {

        use TraitView;

        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'col';

        /**
         * عنصر دادهای
         *
         * @var string
         */
        public $class;

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        /**
         * ایجاد
         *
         * @param  string $class
         * @param  \Closure|array $fields
         * @return void
         */
        public function __construct($class , $fields = [])
        {
            $this->class = $class;
            $this->data = $fields;
        }


    }