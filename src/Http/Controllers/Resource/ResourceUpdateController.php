<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceUpdateController extends Controller
    {
        /**
         * @param ResourceRequest $request
         * @return \Illuminate\Http\RedirectResponse
         */
        public function handle(ResourceRequest $request)
        {

            $resource = $request->findOrfail();

            /**
             * دسترسی سطح بررسی
             */
            $request->Resource()->authorizeToUpdate($resource);

            $where = function($field){
                if(!method_exists($field,'authorizedToSee') || $field->authorizedToSee() === false) return false;
                if($field->showOnUpdate == true && $field->OnUpdate == true)
                    return true;
                else
                    return false;
            };

            // get data for update
            $data = $request->CustomResourceController($request , $resource , 'ResourceUpdate' , $where);

            // Update Resource
            $resource->update($data);

            return back()->with([
                'success' => 'اطلاعات ذخیره شد'
            ]);

        }

    }
