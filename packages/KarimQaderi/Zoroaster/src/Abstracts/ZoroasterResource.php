<?php

    namespace KarimQaderi\Zoroaster\Abstracts;

    use KarimQaderi\Zoroaster\ResourceActions\Delete;
    use KarimQaderi\Zoroaster\ResourceActions\DeleteAll;
    use KarimQaderi\Zoroaster\ResourceActions\Edit;
    use KarimQaderi\Zoroaster\ResourceActions\ForceDelete;
    use KarimQaderi\Zoroaster\ResourceActions\ForceDeleteAll;
    use KarimQaderi\Zoroaster\ResourceActions\Restore;
    use KarimQaderi\Zoroaster\ResourceActions\Show;
    use KarimQaderi\Zoroaster\ResourceFilters\Trashed;
    use KarimQaderi\Zoroaster\Traits\Authorization;

    abstract class ZoroasterResource
    {
        use Authorization;


        public $model = '';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public $title = 'id';

        public $labels = '';
        public $label = '';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public $search = [
            'id' ,
        ];

        abstract public function fields();

        abstract function filters();

        public function AddingAdditionalConstraintsForViewIndex($eloquent)
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