<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceDestroyController extends Controller
    {
        use \KarimQaderi\Zoroaster\Fields\Traits\Validator;

        public function handle(ResourceRequest $request)
        {
            foreach(request()->resourceId as $id){
                if(method_exists($request->Model() , 'isForceDeleting'))
                    $find = $request->Model()->withTrashed()->where([$request->Model()->getKeyName() => $id])->first();
                else
                    $find = $request->Model()->where([$request->Model()->getKeyName() => $id])->first();

                $request->authorizeTo($request->Resource()->authorizeToForceDelete($find));


                $this->ResourceDestroyField($request , $find);

                if(method_exists($request->Model() , 'isForceDeleting'))
                    $find->forceDelete();
                else
                    $request->Model()->destroy($id);

            }

            if(request()->has('redirect'))
                redirect(request()->redirect)->with([
                    'success' => 'منبع مورد نظر حذف شد'
                ])->send();

            return response(['status' => 'ok']);
        }

        private function ResourceDestroyField(ResourceRequest $request , $find)
        {
            $customResourceController = $request->ResourceFields(function($field){ return true; });

            $ResourceError = [];
            foreach($customResourceController as $field){

                $RequestField = new RequestField();
                $RequestField->request = $request->Request();
                $RequestField->resource = $find;
                $RequestField->field = $field;
                $RequestField->fieldAll = $customResourceController;
                $RequestField->MergeResourceFieldsAndRequest = null;

                $ResourceDestroy = (object)$field->ResourceDestroy($RequestField);
                if(isset($ResourceDestroy->error) && $ResourceDestroy->error !== null){

                    if(is_array($ResourceDestroy->error))
                        $ResourceError = array_merge($ResourceError , $ResourceDestroy->error);
                    else
                        $ResourceError = array_merge($ResourceError , $ResourceDestroy->error->messages());

                }
            }


            if(count($ResourceError) !== 0)
                $this->SendErrors($ResourceError);
        }

    }