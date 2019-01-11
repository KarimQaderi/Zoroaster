<?php

    namespace KarimQaderi\Zoroaster\Fields\Extend;

    use Closure;
    use JsonSerializable;

    abstract class Element implements JsonSerializable
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
        public $onlyOnDetail = false;

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
         * مشاهده قابل مجوزه اعمال
         *
         * @param  \Closure $callback
         * @return $this
         */
        public function canSee(Closure $callback)
        {
            $this->seeCallback = $callback;

            return $this;
        }

        /**
         * نه یا هست مشاهده قابل که کند می مشخص
         *
         * @return bool
         */
        public function authorizedToSee()
        {
            return $this->seeCallback ? call_user_func($this->seeCallback) : true;
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


        /**
         * کند می اماده JSON serialization برای را عنصر
         *
         * @return array
         */
        public function jsonSerialize()
        {
            return array_merge([
                'component' => $this->component() ,
                'onlyOnDetail' => $this->onlyOnDetail ,
            ] , $this->meta());
        }

    }
