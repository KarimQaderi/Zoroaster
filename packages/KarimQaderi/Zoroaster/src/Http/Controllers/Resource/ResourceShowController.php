<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class ResourceShowController extends Controller
    {
        public function handle(ResourceRequest $ResourceRequest)
        {

            if(method_exists($ResourceRequest->newModel() , 'isForceDeleting'))
                $resources = $ResourceRequest->newModel()->withTrashed()->findOrFail(($ResourceRequest->RequestParameters()->resourceId));
            else
                $resources = $ResourceRequest->newModel()->findOrFail(($ResourceRequest->RequestParameters()->resourceId));

            $ResourceRequest->Resource()->authorizeToShow($resources);


            return view('Zoroaster::resources.Detail')->with([
                'request' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->newModel() ,
                'resources' => $resources ,
                'fields' => $ResourceRequest->RenderViewForm($ResourceRequest->Resource()->fields() ,
                    function($field)
                    {
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