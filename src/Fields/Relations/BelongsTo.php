<?php

    namespace KarimQaderi\Zoroaster\Fields\Relations;


    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;
    use KarimQaderi\Zoroaster\Zoroaster;

    class BelongsTo extends Field
    {
        use Resource;


        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'belongs-to';



        public $display = null;

        public $routeShow = null;

        public $belongsToRelationship = null;


        public function __construct($label , $name_relations , $model , $belongsToRelationship)
        {

            $this->label = $label;
            $this->name = $name_relations;
            $this->model = $model;
            $this->belongsToRelationship = $belongsToRelationship;

            if(Zoroaster::hasNewResourceByModelName($model))
            {
                if(is_null($this->display))
                    $this->display = Zoroaster::newResourceByModelName($model)->title;

                $this->routeShow = 'Zoroaster.resource.show';
            }


        }

        public function display($Filed)
        {
            $this->display = $Filed;

            return $this;
        }

        public function routeShow($route)
        {
            $this->routeShow = $route;

            return $this;
        }


        public function viewForm($field , $data , $resourceRequest = null)
        {
            $this->hasRelationship($field , $data , $resourceRequest);

            return view('Zoroaster::fields.Form.' . $field->nameViewForm)->with(
                [
                    'value' => is_null($data) ? null : $data->{$field->belongsToRelationship} ,
                    'field' => $field ,
                    'foreign_key' => Zoroaster::newModel($field->model)->getKeyName() ,
                    'all' => Zoroaster::newModel($field->model)->get() ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }

        public function viewDetail($field , $data , $resourceRequest = null)
        {

            $this->hasRelationship($field , $data , $resourceRequest);

            return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                [
                    'data' => is_null($data) ? null : $data ,
                    'data_relation' => is_null($data) ? null : $data->{$field->belongsToRelationship} ,
                    'value' => is_null($data) ? null : $data->{$field->belongsToRelationship}->{$field->display} ,
                    'field' => $field ,
                    'foreign_key' => Zoroaster::newModel($field->model)->getKeyName() ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }

        public function viewIndex($field , $data , $resourceRequest = null)
        {
            $this->hasRelationship($field , $data , $resourceRequest);

            return view('Zoroaster::fields.Index.' . $field->nameViewForm)->with(
                [
                    'data' => is_null($data) ? null : $data ,
                    'data_relation' => is_null($data) ? null : $data->{$field->belongsToRelationship} ,
                    'value' => is_null($data) ? null : $data->{$field->belongsToRelationship}->{$field->display} ,
                    'field' => $field ,
                    'foreign_key' => Zoroaster::newModel($field->model)->getKeyName() ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }

        private function hasRelationship($field , $data , $resourceRequest)
        {

            if(!is_null($data) && !isset($data->{$field->belongsToRelationship}))
                throw new \Exception('Relationship پیدا نشد' . ' به ' . $resourceRequest->resourceClass . ' رفته و  ' . ' BelongsTo ' . ' رو بررسی کنید ');
        }


    }
