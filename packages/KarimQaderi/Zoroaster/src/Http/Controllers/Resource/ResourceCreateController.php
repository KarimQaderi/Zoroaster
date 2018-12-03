<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceCreateController extends Controller
    {
        public function handle(ResourceRequest $request)
        {

            $request->authorizeTo($request->Resource()->authorizeToCreate());

            return view('Zoroaster::resources.Form')->with([
                'request' => $request ,
                'resourceClass' => $request->Resource() ,
                'model' => $request->Model() ,
                'fields' => $request->BuilderFields(function($field){
                    if($field->showOnCreation == true)
                        return true;
                    else
                        return false;
                },'viewForm') ,
            ]);
        }



}