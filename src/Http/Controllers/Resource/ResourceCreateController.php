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

            $where = function($field){
                if(!isset($field->showOnCreation)) return true;
                if($field->showOnCreation == true)
                    return true;
                else
                    return false;
            };

            return view('Zoroaster::resources.Form')->with([
                'request' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Resource()->newModel() ,
                'fields' => $ResourceRequest::RenderForm(
                    $ResourceRequest->Resource()->fields() ,
                    null ,
                    $where,
                    $ResourceRequest
                ) ,
            ]);
        }


    }