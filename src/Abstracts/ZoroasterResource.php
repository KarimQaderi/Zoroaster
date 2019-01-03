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
         * The underlying model resource instance.
         *
         * @var \Illuminate\Database\Eloquent\Model
         */
        public $resource;

        public static $model = '';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public $title = 'id';

        public $labels = '';
        public $label = '';

        /**
         * Indicates if the resoruce should be globally searchable.
         *
         * @var bool
         */
        public $globallySearchable = true;

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public $search = [
            'id' ,
        ];

        public function __construct(){

            $this->resource = new static::$model;
        }

        abstract public function fields();

        abstract function filters();

        /**
         * Get a fresh instance of the model represented by the resource.
         *
         * @return mixed
         */
        public static function newModel()
        {
            $model = static::$model;

            return new $model;
        }

        public static function getModel()
        {
            return  static::$model;
        }

        public function indexQuery($eloquent)
        {
            return $eloquent;
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