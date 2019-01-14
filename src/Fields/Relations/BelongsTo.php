<?php

    namespace KarimQaderi\Zoroaster\Fields\Relations;


    use KarimQaderi\Zoroaster\Exceptions\NotFoundRelationship;
    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;
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

            if(Zoroaster::hasNewResourceByModelName($model)){
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

        /**
         * @param $field
         * @param $data
         * @param ResourceRequest $resourceRequest
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewForm($field , $data , $resourceRequest = null)
        {
            try{
                $this->hasRelationship($field , $data , $resourceRequest);

                return view('Zoroaster::fields.Form.' . $field->nameViewForm)->with(
                    [
                        'value' => is_null($data) ? null : $data->{$field->belongsToRelationship} ,
                        'field' => $field ,
                        'foreign_key' => $resourceRequest->Resource()->getModelKeyName() ,
                        'all' => Zoroaster::newModel($field->model)->get() ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch(\Exception $exception){
                throw new \Exception($exception);
            }
        }

        /**
         * @param $field
         * @param $data
         * @param ResourceRequest $resourceRequest
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewDetail($field , $data , $resourceRequest = null)
        {
            try{
                $this->hasRelationship($field , $data , $resourceRequest);

                return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                    [
                        'data' => is_null($data) ? null : $data ,
                        'data_relation' => is_null($data) ? null : $data->{$field->belongsToRelationship} ,
                        'value' => is_null($data) ? null : $data->{$field->belongsToRelationship}->{$field->display} ,
                        'field' => $field ,
                        'foreign_key' => $resourceRequest->Resource()->getModelKeyName() ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch(\Exception $exception){
                throw new \Exception($exception);
            }
        }

        /**
         * @param $field
         * @param $data
         * @param ResourceRequest $resourceRequest
         * @return \Illuminate\View\View
         * @throws \Exception
         */
        public function viewIndex($field , $data , $resourceRequest = null)
        {
            try{
                $this->hasRelationship($field , $data , $resourceRequest);


                $data_relation = $data->{$field->belongsToRelationship};

                return view('Zoroaster::fields.Index.' . $field->nameViewForm)->with(
                    [
                        'data' => is_null($data) ? null : $data ,
                        'data_relation' => is_null($data) || is_null($data_relation) ? null : $data_relation ,
                        'value' => is_null($data) || is_null($data_relation) ? null : $data_relation->{$field->display} ,
                        'field' => $field ,
                        'foreign_key' => $resourceRequest->Resource()->getModelKeyName() ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            } catch(\Exception $exception){
                throw new \Exception($exception);
            }
        }


        private function hasRelationship($field , $data , $resourceRequest)
        {

            if(!is_null($data) && !method_exists($data , $field->belongsToRelationship))
                throw (new NotFoundRelationship())->setRelationship(request()->resourceClass);

        }


    }
