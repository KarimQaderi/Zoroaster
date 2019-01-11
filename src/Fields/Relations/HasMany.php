<?php

    namespace KarimQaderi\Zoroaster\Fields\Relations;

    use KarimQaderi\Zoroaster\Fields\Extend\Field;

    class HasMany extends Field
    {

        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'relationship';


        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'has-many';

        public $resourceClass;

        public $resourceName;

        public $relationship_id;


        /**
         * HasMany .
         *
         * @param      $name
         * @param      $relationship_id
         * @param      $resource
         */
        public function __construct($name , $relationship_id , $resource)
        {
            $this->resourceClass = new $resource;
            $this->name = $name;
            $this->relationship_id = $relationship_id;

            $this->hideFromIndex();
            $this->hideWhenUpdating();
            $this->hideWhenCreating();
        }

        /**
         *
         * @return bool
         */
        public function authorizedToIndex($field)
        {
            return $field->resourceClass->authorizedToIndex($field->resourceClass->newModel());

        }

        public function viewDetail($field , $data , $resourceRequest = null)
        {

            return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                [
                    'data' => is_null($data) ? null : $data ,
                    'field' => $field ,
                    'resourceRequest' => $resourceRequest ,
                    'resource' => $field->resourceClass ,
                ]);
        }


    }
