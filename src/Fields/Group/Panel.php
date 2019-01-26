<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;

    class Panel
    {
        use TraitView;

        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'field_group';

        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'panel';

        /**
         * عنصر دادهای
         *
         * @var string
         */
        public $class;

        /**
         * دیتابیس در عنصر فیلد نام
         *
         * @var string
         */
        public $name;

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        /**
         * ایجاد
         *
         * @param  string $name
         * @param  array $fields
         * @param  string $class
         * @return void
         */
        public function __construct($name , $fields = [] , $class = null)
        {
            $this->name = $name;
            $this->class = $class;
            $this->data = $fields;

        }

    }