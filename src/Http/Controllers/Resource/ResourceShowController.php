<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceShowController extends Controller
    {
        public function handle(ResourceRequest $ResourceRequest)
        {

            /**
             * نظر مورد رکورد کردن پیدا
             */
            $resources = $ResourceRequest->findOrfail();

            /**
             * دسترسی سطح بررسی
             */
            $ResourceRequest->Resource()->authorizeToShow($resources);


            return view('Zoroaster::resources.Detail')->with([
                'request' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Resource()->newModel() ,
                'resources' => $resources ,
                'fields' => $ResourceRequest->RenderViewForm($ResourceRequest->Resource()->fields() ,
                    function($field){
                        if(!isset($field->showOnDetail)) return true;
                        if($field->showOnDetail === true)
                            return true;
                        else
                            return false;
                    } ,
                    'viewDetail' , $resources , $ResourceRequest) ,
            ]);
        }

    }