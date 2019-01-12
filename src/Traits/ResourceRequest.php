<?php

    namespace KarimQaderi\Zoroaster\Traits;

    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Zoroaster;

    trait ResourceRequest
    {

        public $resourceClass = null;
        private $Resource = null;


        public function __construct()
        {

            $this->resourceClass = \Zoroaster::getCurrentRouteResource();

            if(is_null($this->resourceClass)) abort(404);

            $this->Resource = $this->Resource();

            if(is_null($this->Resource)) abort(404);


        }

        public function RequestParameters()
        {
            return (object)Route::getCurrentRoute()->parameters();
        }

        public function Request()
        {
            return request();
        }

        public function getRequest($request)
        {
            return request()->get($request);
        }

        public function getResourceId()
        {
            return $this->RequestParameters()->resourceId;
        }

        public function getResourceName()
        {
            return $this->RequestParameters()->resource;
        }


        /**
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource
         */
        public function Resource()
        {
            return $this->Resource = Zoroaster::newResource($this->resourceClass);
        }


        public function ResourceFields($where , $fields = null)
        {
            $Fields = [];
            $fields = ($fields == null) ? $this->Resource()->fields() : $fields;

            foreach($fields as $field){
                switch(true){
                    case isset($field->data):
                        if($Fields == null)
                            $Fields = $this->ResourceFields($where , $field->data);
                        else
                            $Fields = array_merge($Fields , $this->ResourceFields($where , $field->data));
                        break;

                    default:
                        if($where($field) === true)
                            $Fields [] = $field;
                        break;
                }
            }

            return $Fields;
        }

        public function MergeResourceFieldsAndRequest($fields)
        {
            $requestMerge = [];
            $validator = [];
            $customAttributes = [];

            foreach($fields as $field){
                $requestMerge = array_merge($requestMerge , [$field->name => $this->getRequest($field->name)]);
                if(count($field->rules) != 0){
                    $validator = array_merge($validator , [$field->name => $field->rules]);
                    $customAttributes = array_merge($customAttributes , [$field->name => $field->label]);
                }
            }

            return (object)[
                'validator' => $validator ,
                'request' => $requestMerge ,
                'customAttributes' => $customAttributes ,
            ];
        }


        public function BuilderFields($where , $view , $resources = null , $fields = null)
        {
            $Fields = null;
            $fields = ($fields === null) ? $this->Resource()->fields() : $fields;
            foreach($fields as $field){
                switch(true){

                    case isset($field->data):
                        $Fields .= $field->$view($this->BuilderFields($where , $view , $resources , $field->data) , $field , $this->Resource());
                        break;

                    default:
                        if($where($field) === true)
                            $Fields .= $field->$view($resources , $field , $this->Resource());

                        break;
                }
            }

            return $Fields;
        }

    }