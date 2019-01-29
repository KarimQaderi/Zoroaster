<?php

    namespace KarimQaderi\Zoroaster\Abstracts;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Http\Resources\DelegatesToResource;
    use Illuminate\Support\Str;
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
        use Authorizable , DelegatesToResource;


        public $component = 'resource';

        /**
         *  صفحه ادرس
         *
         * @var string
         */
        public $uriKey;

        /**
         * @var Model
         */
        public $resource;

        /**
         * مربوطه Model نام
         *
         * @var Model
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
        public $label = '';

        /**
         * فرد بصورت Resource نام
         *
         * مثال : پست
         *
         * @var string
         */
        public $singularLabel = '';

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

        /**
         * دادها نمایش برای فیلدها گرفتن
         *
         * @return array
         */
        abstract public function fields();

        /**
         * دادها نمایش برای فیلدها گرفتن
         *
         * @return array
         */
        abstract function filters();

        /**
         * جدید Model گرفتن
         *
         * @return Model & Builder & SoftDeletes
         */
        public static function newModel()
        {
            $model = static::$model;

            return new $model;
        }

        /**
         * اصلی ID ستون  گرفتن
         *
         * @return string
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
         * index صفحه برای query اعمال
         *
         * @param  \Illuminate\Database\Eloquent\Builder $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        public function indexQuery($query)
        {
            return $query;
        }


        /**
         * صفحه ادرس گرفتن
         *
         * @return string
         */
        public function uriKey()
        {
            return Str::snake($this->uriKey ?? class_basename(get_called_class()) , '-');
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