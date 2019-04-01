<?php

    namespace KarimQaderi\Zoroaster\Http\Requests;


    use KarimQaderi\Zoroaster\Fields\Traits\Validator;
    use KarimQaderi\Zoroaster\Traits\Builder;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest as TraitsResourceRequest;

    /**
     * Class ResourceRequest
     * @package KarimQaderi\Zoroaster\Http\Requests
     */
    class ResourceRequest
    {
        use TraitsResourceRequest , Builder , Validator;

        /**
         * @param $authorize
         */
        function authorizeTo($authorize)
        {
            if(!$authorize)
                abort(401);
        }


        /**
         * @param ResourceRequest $request
         * @param $resource
         * @param $method
         * @param $where
         * @return array
         */
        public function CustomResourceController(ResourceRequest $request , $resource , $method , $where)
        {

            $fieldAll = $request->ResourceFields($where);
            $MergeResourceFieldsAndRequest = $request->MergeResourceFieldsAndRequest($fieldAll);

            $ResourceData = [];
            $ResourceError = [];
            foreach($fieldAll as $field){

                if(!method_exists($field , $method)) continue;

                $RequestField = new RequestField();
                $RequestField->request = $request->Request();
                $RequestField->resource = $resource;
                $RequestField->field = $field;
                $RequestField->fieldAll = $fieldAll;
                $RequestField->MergeResourceFieldsAndRequest = $MergeResourceFieldsAndRequest;


                $beforeResourceData = (object)$field->$method($RequestField);


                if(isset($beforeResourceData->error) && $beforeResourceData->error !== null){

                    if(is_array($beforeResourceData->error))
                        $ResourceError = array_merge($ResourceError , $beforeResourceData->error);
                    else
                        $ResourceError = array_merge($ResourceError , $beforeResourceData->error->messages());

                } elseif(isset($beforeResourceData->data))
                    $ResourceData = array_merge($ResourceData , $beforeResourceData->data);

            }

            if(count($ResourceError) !== 0){
                $this->SendErrors($ResourceError);
            } else
                return $ResourceData;
        }


    }