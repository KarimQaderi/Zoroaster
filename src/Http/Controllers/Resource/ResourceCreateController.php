<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceCreateController extends Controller
    {
        public function handle(ResourceRequest $ResourceRequest)
        {

            /**
             * دسترسی سطح بررسی
             */
            $ResourceRequest->Resource()->authorizeToCreate($ResourceRequest->Resource()->newModel());

            return view('Zoroaster::resources.Form')->with([
                'request' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Resource()->newModel() ,
                'fields' => $ResourceRequest->RenderViewForm($ResourceRequest->Resource()->fields() ,
                    function($field){
                        if(!isset($field->showOnCreation)) return true;
                        if($field->showOnCreation == true)
                            return true;
                        else
                            return false;
                    } ,
                    'viewForm' , null , $ResourceRequest) ,
            ]);
        }


    }