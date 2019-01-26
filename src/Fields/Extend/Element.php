<?php

    namespace KarimQaderi\Zoroaster\Fields\Extend;


    abstract class Element
    {
        use ProxiesCanSeeToGate;


        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = '';


        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'field';

        /**
         * مشاهده قابل مجوزه فراخوانی
         *
         * @var \Closure|null
         */
        public $seeCallback;

        /**
         * detail صفحه در مشاهده قابل فقط
         *
         * @var bool
         */
        public $onlyOnDetail = true;

        /**
         * عنصر دادهای
         *
         * @var array
         */
        public $meta = [];

        /**
         * عنصر ایجاد
         *
         * @param  string|null $component
         * @return void
         */
        public function __construct($component = null)
        {
            $this->component = $component ?? $this->component;
        }

        /**
         * عنصر ایجاد
         *
         * @return static
         */
        public static function make(...$arguments)
        {
            return new static(...$arguments);
        }


        /**
         * عنصر نام گرفتن
         *
         * @return string
         */
        public function component()
        {
            return $this->component;
        }

        /**
         * detail صفحه در مشاهده قابل فقط اعمال
         *
         * @return $this
         */
        public function onlyOnDetail()
        {
            $this->onlyOnDetail = true;

            return $this;
        }

        /**
         * عنصر دادهای گرفتن
         *
         * @return array
         */
        public function meta()
        {
            return $this->meta;
        }

        /**
         * جدید عنصر داده کردن اضافه
         *
         * @param  array $meta
         * @return $this
         */
        public function withMeta(array $meta)
        {
            $this->meta = array_merge($this->meta , $meta);

            return $this;
        }



    }
