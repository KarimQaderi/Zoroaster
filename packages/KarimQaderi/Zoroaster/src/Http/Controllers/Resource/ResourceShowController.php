<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceShowController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            if(method_exists($request->Model() , 'isForceDeleting'))
            $resources = $request->Model()->withTrashed()->findOrFail(($request->RequestParameters()->resourceId));
            else
            $resources = $request->Model()->findOrFail(($request->RequestParameters()->resourceId));

            $request->authorizeTo($request->Resource()->authorizeToShow($resources));

            return view('Zoroaster::resources.Detail')->with([
                'request' => $request ,
                'resourceClass' => $request->Resource() ,
                'model' => $request->Model() ,
                'resources' => $resources ,
                'fields' => $request->BuilderFields(
                    function($field){
                        if($field->showOnDetail == true)
                            return true;
                        else
                            return false;
                    } ,'viewDetail',
                    $resources) ,
            ]);
        }

}