<?php

    namespace KarimQaderi\Zoroaster\Traits;

    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Zoroaster;

    trait ResourceRequest
    {

        public $resourceClass = null;
        private $Resource = null;


        public function __construct()
        {

            $this->Resource = Zoroaster::resourceFindByUriKey(\Zoroaster::getParameterCurrentRoute('resource'));

            if(is_null($this->Resource)) abort(404);

            $this->resourceClass = $this->Resource->uriKey();

        }

        /**
         * @return object|\Illuminate\Database\Eloquent\Builder & \Illuminate\Database\Eloquent\Model
         */
        public function findOrfail()
        {

            if(!is_null($model = $this->find())){
                $this->Resource()->resource = $model;
                return $model;
            }

            throw (new ModelNotFoundException())->setModel($this->Resource()->getModel());

        }

        /**
         * @return object|\Illuminate\Database\Eloquent\Builder & \Illuminate\Database\Eloquent\Model
         */
        public function find($find = null)
        {
            $find =$this->getModelAndWhereTrashed()
                ->where([$this->Resource()->getModelKeyName() => $find ?? $this->getResourceId()])
                ->first();

            $this->Resource()->resource = $find;

            return $find;
        }


        /**
         * @return \Illuminate\Database\Eloquent\Model & \Illuminate\Database\Eloquent\Builder
         */
        function getModelAndWhereTrashed()
        {
            if($this->isForceDeleting())
                return $this->Resource()->newModel()->withTrashed();
            else
                return $this->Resource()->newModel();
        }

        /**
         * @return bool
         */
        function isForceDeleting()
        {
            return method_exists($this->Resource()->newModel() , 'isForceDeleting');
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
            return \Zoroaster::getParameterCurrentRoute('resourceId');
        }

        public function getResourceName()
        {
            return \Zoroaster::getParameterCurrentRoute('resource');
        }


        /**
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource
         */
        public function Resource()
        {
            return $this->Resource;
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


        /**
         * ها فیلد گرفتن
         *
         * @param $where
         * @param $view
         * @param null $resources
         * @param null $fields
         * @return string|null
         */
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