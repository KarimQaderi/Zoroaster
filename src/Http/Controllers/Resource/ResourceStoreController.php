<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceStoreController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            /**
             * دسترسی سطح بررسی
             */
            $request->Resource()->authorizeToCreate($request->Resource()->newModel());

            $where = function($field){
                if(!method_exists($field,'authorizedToSee') || $field->authorizedToSee() === false) return false;
                if($field->showOnCreation == true && $field->OnCreation == true)
                    return true;
                else
                    return false;
            };

            // get data for store
            $data = $request->CustomResourceController($request , $request->Resource()->newModel() , 'beforeResourceStore' , $where);

            // Store Resource
            $resource = $request->Resource()->newModel()->create($data);

            // Set Data
            $request->Resource()->resource = $resource;

            // Resource Update
            $request->CustomResourceController($request , $resource , 'ResourceStore' , $where);

            if(request()->redirect != null)
                return redirect(request()->redirect)->with(['success' => 'اطلاعات اضافه شد']);

            return redirect(route('Zoroaster.resource.show' ,
                [
                    'resource' => $request->getResourceName() , 'resourceId' => $resource->{$request->Resource()->getModelKeyName()}
                ]))->with(['success' => 'اطلاعات اضافه شد']);

        }

    }
