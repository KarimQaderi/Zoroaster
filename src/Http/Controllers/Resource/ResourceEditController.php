<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceEditController extends Controller
    {
        public function handle(ResourceRequest $ResourceRequest)
        {

            /**
             * نظر مورد رکورد کردن پیدا
             */
            $resources = $ResourceRequest->newModel()->findOrFail(($ResourceRequest->RequestParameters()->resourceId));

            /**
             * دسترسی سطع بررسی
             */
            $ResourceRequest->Resource()->authorizeToUpdate($resources);


            return view('Zoroaster::resources.Form')->with([
                'request' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->newModel() ,
                'resources' => $resources ,
                'fields' => $ResourceRequest->RenderViewForm($ResourceRequest->Resource()->fields() ,
                    function($field){
                        if(!isset($field->showOnUpdate)) return true;
                        if($field->showOnUpdate == true)
                            return true;
                        else
                            return false;
                    } ,
                    'viewForm' , $resources , $ResourceRequest) ,
            ]);
        }


    }