<?php

    namespace KarimQaderi\Zoroaster\Fields\Relations;


    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;
    use KarimQaderi\Zoroaster\Zoroaster;

    class BelongsTo extends Field
    {
        use Resource;
        /**
         * The field's component.
         *
         * @var string
         */
        public $nameViewForm = 'belongs-to';

        /**
         * The field's component.
         *
         * @var string
         */
        public $displayTitleField = null;


        public $routeShow = null;


        public function __construct($label , $name , $model , $foreign_key = null , $other_key = null)
        {

            $this->label = $label;
            $this->name = $name;
            $this->model = $model;

            if(is_null($foreign_key))
                $this->foreign_key = Zoroaster::newModel($model)->getKeyName();
            else
                $this->foreign_key = $foreign_key;

            if(is_null($other_key))
                $this->other_key = 'id';
            else
                $this->other_key = $other_key;

            if(is_null($this->displayTitleField))
                $this->displayTitleField = Zoroaster::newResourceByModelName($model)->title;

            if(Zoroaster::hasNewResourceByModelName($model))
                $this->routeShow = 'Zoroaster.resource.show';


        }

        public function displayTitleField($Filed)
        {
            $this->displayTitleField = $Filed;

            return $this;
        }

        public function routeShow($route)
        {
            $this->routeShow = $route;

            return $this;
        }


        public function viewForm($field , $data , $resourceRequest = null)
        {
            return view('Zoroaster::fields.Form.' . $field->nameViewForm)->with(
                [
                    'data' => is_null($data) ? null : Zoroaster::newModel($field->model)->where([$field->foreign_key => $data->{$field->name}])->first() ,
                    'field' => $field ,
                    'all' => Zoroaster::newModel($field->model)->get() ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }

        public function viewDetail($field , $data , $resourceRequest = null)
        {
            return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                [
                    'data' => is_null($data) ? null : Zoroaster::newModel($field->model)->where([$field->foreign_key => $data->{$field->name}])->first() ,
                    'field' => $field ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }

        public function viewIndex($field , $data , $resourceRequest = null)
        {
            return view('Zoroaster::fields.Index.' . $field->nameViewForm)->with(
                [
                    'data' => Zoroaster::newModel($field->model)->where([$field->foreign_key => $data->{$field->name}])->first() ,
                    'field' => $field ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }


    }
