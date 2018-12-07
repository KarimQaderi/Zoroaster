<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceUpdateController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            $MergeResourceFieldsAndRequest = $request->MergeResourceFieldsAndRequest($request->ResourceFields(function($field){
                if($field->showOnUpdate == true && $field->OnUpdate == true)
                    return true;
                else
                    return false;
            }));


//            $validator = Validator::make($data->request , $data->validator , [] , $data->customAttributes);
//            if($validator->fails())
//                return redirect()->back()->withErrors($validator->messages())->withInput();


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

//            $resource->update($data->request);

            return $resource;
        }

        /**
         * @param ResourceRequest $request
         * @param $resource
         */
        private function CustomResourceController(ResourceRequest $request , $resource , $MergeResourceFieldsAndRequest): void
        {
            $customResourceController = $request->ResourceFields(function($field){
                if($field->OnUpdate == true)
                    return true;
                else
                    return false;
            });

            $Update = [];

            foreach($customResourceController as $field){

                $RequestField = new RequestField();
                $RequestField->request = $request->Request();
                $RequestField->resource = $resource;
                $RequestField->field = $field;
                $RequestField->fieldAll = $customResourceController;
                $RequestField->MergeResourceFieldsAndRequest = $MergeResourceFieldsAndRequest;

                $Update = array_merge($Update , $field->ResourceUpdate($RequestField));

            }

            $resource->update($Update);



        }


    }