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

            $request->authorizeTo($request->Resource()->authorizeToCreate($request->Model()));

            $MergeResourceFieldsAndRequest = $request->MergeResourceFieldsAndRequest($request->ResourceFields(function($field){
                if($field->showOnCreation == true && $field->OnCreation == true)
                    return true;
                else
                    return false;
            }));


//            $validator = Validator::make($data->request , $data->validator , [] , $data->customAttributes);
//            if($validator->fails())
//                return redirect()->back()->withErrors($validator->messages())->withInput();


//            $this->CustomResourceController($request , $MergeResourceFieldsAndRequest,'beforeResourceStore');
            $resource = $request->Model()->create($this->CustomResourceController($request , $request->Model() , $MergeResourceFieldsAndRequest , 'beforeResourceStore'));

            $this->CustomResourceController($request , $resource , $MergeResourceFieldsAndRequest , 'beforeResourceStore');

            if(request()->redirect != null)
                return redirect(request()->redirect)->with([
                    'success' => 'اطلاعات اضافه شد'
                ]);

            return redirect(route('Zoroaster.resource.show' , ['resource' => $request->getResourceName() , 'resourceId' => $resource->{$request->Model()->getKeyName()}]))->with([
                'success' => 'اطلاعات اضافه شد'
            ]);

        }


        /**
         * @param ResourceRequest $request
         * @param $resource
         */
        private function CustomResourceController(ResourceRequest $request , $resource , $MergeResourceFieldsAndRequest , $method)
        {
            $customResourceController = $request->ResourceFields(function($field){
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

            if(count($ResourceError) !== 0)
                $this->SendErrors($ResourceError);
            else
                return $ResourceData;
        }


    }