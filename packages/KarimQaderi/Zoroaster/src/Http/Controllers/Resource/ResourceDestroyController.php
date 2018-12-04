<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceDestroyController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            $request->authorizeTo($request->Resource()->authorizeToDelete($request->Model()->find(request()->resourceId)));

            $request->Model()->destroy(request()->resourceId);


            dd(request()->has('redirect'));
            if(request()->has('redirect'))
                 redirect(request()->redirect)->with([
                    'success' => 'منبع مورد نظر حذف شد'
                ])->send();

            return response([
                'status' => 'ok'
            ]);
        }

}