<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceStoreController extends Controller
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public function handle(ResourceRequest $request)
        {

            /**
             * دسترسی سطح بررسی
             */
            $request->Resource()->authorizeToCreate($request->Resource()->newModel());


            $MergeResourceFieldsAndRequest = $request->MergeResourceFieldsAndRequest($request->ResourceFields(function($field){
                if($field->authorizedToSee() === false) return false;
                if($field->showOnCreation == true && $field->OnCreation == true)
                    return true;
                else
                    return false;
            }));


            $resource = $request->Resource()->newModel()->create($this->CustomResourceController($request , $request->Resource()->newModel() , $MergeResourceFieldsAndRequest , 'beforeResourceStore'));

            $request->Resource()->resource = $resource;

            $this->CustomResourceController($request , $resource , $MergeResourceFieldsAndRequest , 'ResourceStore');

            if(request()->redirect != null)
                return redirect(request()->redirect)->with(['success' => 'اطلاعات اضافه شد']);

            return redirect(route('Zoroaster.resource.show' ,
                [
                    'resource' => $request->getResourceName() , 'resourceId' => $resource->{$request->Resource()->getModelKeyName()}
                ]))->with(['success' => 'اطلاعات اضافه شد']);

        }


        private function CustomResourceController(ResourceRequest $request , $resource , $MergeResourceFieldsAndRequest , $method)
        {
            $customResourceController = $request->ResourceFields(function($field){
                if($field->authorizedToSee() === false) return false;
                if($field->showOnCreation == true && $field->OnCreation == true)
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


                $beforeResourceData = (object)$field->$method($RequestField);


                if(isset($beforeResourceData->error) && $beforeResourceData->error !== null){

                    if(is_array($beforeResourceData->error))
                        $ResourceError = array_merge($ResourceError , $beforeResourceData->error);
                    else
                        $ResourceError = array_merge($ResourceError , $beforeResourceData->error->messages());

                } else
                    $ResourceData = array_merge($ResourceData , $beforeResourceData->data);

            }

            if(count($ResourceError) !== 0){
                $this->SendErrors($ResourceError);
            } else
                return $ResourceData;
        }


    }