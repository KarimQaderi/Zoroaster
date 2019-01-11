<?php

    namespace KarimQaderi\Zoroaster\Abstracts;

    use KarimQaderi\Zoroaster\ResourceActions\Delete;
    use KarimQaderi\Zoroaster\ResourceActions\DeleteAll;
    use KarimQaderi\Zoroaster\ResourceActions\Edit;
    use KarimQaderi\Zoroaster\ResourceActions\ForceDelete;
    use KarimQaderi\Zoroaster\ResourceActions\ForceDeleteAll;
    use KarimQaderi\Zoroaster\ResourceActions\Restore;
    use KarimQaderi\Zoroaster\ResourceActions\Show;
    use KarimQaderi\Zoroaster\Traits\Authorizable;

    abstract class ZoroasterResource
    {
        use Authorizable;


        public $component = 'resource';

        /**
         * @var \Illuminate\Database\Eloquent\Model
         */
        public $resource;

        /**
         * مربوطه Model نام
         *
         * @var \Illuminate\Database\Eloquent\Model
         */
        public static $model = '';

        /**
         * دادن نمایش برای پیشفرض فیلد نام
         *
         * @var string
         */
        public $title = 'id';

        /**
         * جمع بصورت Resource نام
         *
         * مثال : ها پست
         *
         * @var string
         */
        public $labels = '';

        /**
         * فرد بصورت Resource نام
         *
         * مثال : پست
         *
         * @var string
         */
        public $label = '';

        /**
         * سراسری جستجوی کردن فعال غیر یا فعال
         *
         * @var bool
         */
        public $globallySearchable = true;

        /**
         * جستحو قابل های فیلد
         *
         * @var array
         */
        public $search = ['id'];

        public function __construct()
        {

            $this->resource = new static::$model;
        }

        abstract public function fields();

        abstract function filters();

        /**
         * جدید Model گرفتن
         *
         * @return \Illuminate\Database\Eloquent\Model
         */
        public static function newModel()
        {
            $model = static::$model;

            return new $model;
        }

        /**
         * اصلی ID ستون  گرفتن
         *
         * @return mixed
         */
        public function getModelKeyName()
        {
            return $this->newModel()->getKeyName();
        }

        /**
         * Model گرفتن
         *
         * @return mixed
         */
        public static function getModel()
        {
            return static::$model;
        }


        /**
         * index صغحه برای query اعمال
         *
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function indexQuery($query)
        {
            return $query;
        }

        public function ResourceActions()
        {
            return [
                new Show() ,
                new Edit() ,
                new Delete() ,
                new DeleteAll() ,
                new ForceDeleteAll() ,
                new ForceDelete() ,
                new Restore() ,
            ];
        }

    }