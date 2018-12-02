<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Validator;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceStoreController extends Controller
    {
        public function handle(ResourceRequest $request)
        {
            $data = $request->MergeResourceFieldsAndRequest($request->ResourceFields(function($field){
                if($field->showOnCreation == true && $field->OnUpdate == true && $field->customResourceController == false)
                    return true;
                else
                    return false;
            }));



            $validator = Validator::make($data->request , $data->validator , [] , $data->customAttributes);
            if($validator->fails())
                return redirect()->back()->withErrors($validator->messages())->withInput();


            $resource = $request->Model()->create($data->request);

            $this->CustomResourceController($request , $resource , $data->validator , $data->customAttributes);


            return redirect(route('Zoroaster.resource.edit' , ['resource' => $request->getResourceName() , 'resourceId' => $resource->{$request->Model()->getKeyName()}]))->with([
                'success' => 'اطلاعات اضافه شد'
            ]);

        }



        /**
         * @param ResourceRequest $request
         * @param $resource
         */
        private function CustomResourceController(ResourceRequest $request , $resource , $validator , $customAttributes): void
        {
            $customResourceController = $request->ResourceFields(function($field){
                if($field->OnUpdate == true && $field->customResourceController == true)
                    return true;
                else
                    return false;
            });

            foreach($customResourceController as $field){

                $RequestField = new RequestField();
                $RequestField->request = $request->Request();
                $RequestField->resource = $resource;
                $RequestField->field = $field;
                $RequestField->fieldAll = $customResourceController;
                $RequestField->validator = $validator;
                $RequestField->customAttributes = $customAttributes;

                $field->ResourceUpdate($RequestField);

            }
        }



    }