<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceDestroyController extends Controller
    {
        public function handle(ResourceRequest $request)
        {
            foreach(request()->resourceId as $id){
                if(method_exists($request->Model() , 'isForceDeleting'))
                    $find = $request->Model()->withTrashed()->where([$request->Model()->getKeyName() => $id])->first();
                else
                    $find = $request->Model()->where([$request->Model()->getKeyName() => $id])->first();

                $request->authorizeTo($request->Resource()->authorizeToForceDelete($find));

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

    }