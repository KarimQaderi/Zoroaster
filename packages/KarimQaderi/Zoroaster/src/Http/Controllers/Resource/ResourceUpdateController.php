<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Validator;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceUpdateController extends Controller
    {
        public function handle(ResourceRequest $request)
        {


            $data = $request->MergeResourceFieldsAndRequest($request->ResourceFields(function($field){
                if($field->showOnUpdate == true && $field->OnUpdate == true && $field->customResourceController == false)
                    return true;
                else
                    return false;
            }));


            $validator = Validator::make($data->request , $data->validator , [] , $data->customAttributes);
            if($validator->fails())
                return redirect()->back()->withErrors($validator->messages())->withInput();


            $resource = $this->Update($request , $data);


            $this->CustomResourceController($request , $resource , $data->validator , $data->customAttributes);


            return back()->with([
                'success' => 'اطلاعات ذخیره شد'
            ]);

        }


        /**
         * @param ResourceRequest $request
         * @param $data
         * @return mixed
         */
        private function Update(ResourceRequest $request , $data)
        {
            $resource = $request->Model()->where([$request->Model()->getKeyName() => $request->getResourceId()])->first();

            if(empty($resource)) abort(404);

            $request->authorizeTo($request->Resource()->authorizeToUpdate($resource));

            $resource->update($data->request);

            return $resource;
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