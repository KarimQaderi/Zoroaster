<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceUpdateController extends Controller
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public function handle(ResourceRequest $request)
        {

            $MergeResourceFieldsAndRequest = $request->MergeResourceFieldsAndRequest($request->ResourceFields(function($field){
                if($field->showOnUpdate == true && $field->OnUpdate == true)
                    return true;
                else
                    return false;
            }));



            $resource = $this->Update($request);

            $this->CustomResourceController($request , $resource , $MergeResourceFieldsAndRequest);


            return back()->with([
                'success' => 'اطلاعات ذخیره شد'
            ]);

        }


        /**
         * @param ResourceRequest $request
         * @return mixed
         */
        private function Update(ResourceRequest $request)
        {
            $resource = $request->Model()->where([$request->Model()->getKeyName() => $request->getResourceId()])->first();

            if(empty($resource)) abort(404);

            $request->authorizeTo($request->Resource()->authorizeToUpdate($resource));

            return $resource;
        }

        /**
         * @param ResourceRequest $request
         * @param $resource
         */
        private function CustomResourceController(ResourceRequest $request , $resource , $MergeResourceFieldsAndRequest): void
        {
            $customResourceController = $request->ResourceFields(function($field){
                if($field->showOnUpdate == true && $field->OnUpdate == true)
                    return true;
                else
                    return false;
            });

            $ResourceData = [];
            $ResourceError = [];

            foreach($customResourceController as $field){

                $RequestField = new RequestField();
                $RequestField->request = $request->Request();
                $RequestField->resource = $resource;
                $RequestField->field = $field;
                $RequestField->fieldAll = $customResourceController;
                $RequestField->MergeResourceFieldsAndRequest = $MergeResourceFieldsAndRequest;

                $ResourceUpdate = (object)$field->ResourceUpdate($RequestField);
                if(isset($ResourceUpdate->error) && $ResourceUpdate->error !== null){

                    if(is_array($ResourceUpdate->error))
                        $ResourceError = array_merge($ResourceError , $ResourceUpdate->error);
                    else
                        $ResourceError = array_merge($ResourceError , $ResourceUpdate->error->messages());

                } else
                    $ResourceData = array_merge($ResourceData , $ResourceUpdate->data);



            }

            if(count($ResourceError) !== 0)
                $this->SendErrors($ResourceError);
            else
                $resource->update($ResourceData);


        }


    }