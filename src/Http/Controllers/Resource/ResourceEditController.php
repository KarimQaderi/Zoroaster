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
            $resources = $ResourceRequest->findOrfail();
            /**
             * دسترسی سطح بررسی
             */
            $ResourceRequest->Resource()->authorizeToUpdate($resources);

            $where = function($field){
                if(!isset($field->showOnUpdate)) return true;
                if($field->showOnUpdate == true)
                    return true;
                else
                    return false;
            };

            return view('Zoroaster::resources.Form')->with([
                'request' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Resource()->newModel() ,
                'resources' => $resources ,
                'fields' => $ResourceRequest::RenderForm(
                    $ResourceRequest->Resource()->fields() ,
                    $resources ,
                    $where ,
                    $ResourceRequest
                ) ,
            ]);
        }


    }