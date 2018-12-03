<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceEditController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            $request->authorizeTo($request->Resource()->authorizeToUpdate());

            $resources = $request->Model()->findOrFail(($request->RequestParameters()->resourceId));


            return view('Zoroaster::resources.Form')->with([
                'request' => $request ,
                'resourceClass' => $request->Resource() ,
                'model' => $request->Model() ,
                'resources' => $resources ,
                'fields' => $request->BuilderFields(
                    function($field){
                        if($field->showOnUpdate == true)
                            return true;
                        else
                            return false;
                    } ,'viewForm', $resources) ,
            ]);
        }


    }