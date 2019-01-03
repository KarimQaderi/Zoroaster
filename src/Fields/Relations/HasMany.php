<?php

    namespace KarimQaderi\Zoroaster\Fields\Relations;

    use Illuminate\Http\Request;
    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class HasMany extends Field
    {

        public $component = 'relationship';

        public $nameViewForm = 'has-many';


        public $resourceClass;


        public $resourceName;


        public $relationship_id;


        /**
         * HasMany constructor.
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
         * @param Request $field
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
