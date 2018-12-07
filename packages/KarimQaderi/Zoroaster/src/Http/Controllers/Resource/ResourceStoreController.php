<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceStoreController extends Controller
    {
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
            $resource = $request->Model()->create($this->CustomResourceController($request , null , $MergeResourceFieldsAndRequest , 'beforeResourceStore'));

            $this->CustomResourceController($request , $resource , $MergeResourceFieldsAndRequest , 'beforeResourceStore');

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

            $beforeResourceStore = [];
            foreach($customResourceController as $field){

                $RequestField = new RequestField();
                $RequestField->request = $request->Request();
                $RequestField->resource = $resource;
                $RequestField->field = $field;
                $RequestField->fieldAll = $customResourceController;
                $RequestField->validator = $MergeResourceFieldsAndRequest->validator;
                $RequestField->customAttributes = $MergeResourceFieldsAndRequest->customAttributes;

                $beforeResourceStore = array_merge($beforeResourceStore , $field->$method($RequestField));

            }

            return $beforeResourceStore;
        }


    }