<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\Traits\ResourceIndexQuery;

    class ResourceIndexController extends Controller
    {
        use ResourceIndexQuery;

        public function handle(ResourceRequest $ResourceRequest)
        {

            /**
             * دسترسی سطح بررسی
             */
            $ResourceRequest->Resource()->authorizeToIndex($ResourceRequest->Resource()->newModel());

            if(!request()->ajax())
                return view('Zoroaster::resources.index')->with([
                    'resource' => $ResourceRequest->Resource() ,
                    'resourceClass' => $ResourceRequest->Resource() ,
                    'ResourceRequest' => $ResourceRequest ,
                    'model' => $ResourceRequest->Resource()->newModel() ,
                    'CardIndex' => $ResourceRequest::RenderForm($ResourceRequest->Resource()->CardIndex()),
                ]);

            /**
             * فیلترها اعمال
             *
             * @var Model $resources
             */
            try{
                $resources = $this->toQuery($ResourceRequest->Resource()->newModel() , $ResourceRequest);
            } catch(\Exception $exception){
                return response()->json([
                    'error' => $exception->getMessage()
                ]);
            }

            $where = function($field){
                if(isset($field->showOnIndex) && $field->showOnIndex == true)
                    return true;
                else
                    return false;
            };

            $render = view('Zoroaster::resources.index-resource')->with([
                'ResourceRequest' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Resource()->newModel() ,
                'resources' => $resources ,
                'fields' => $ResourceRequest->ResourceFields($where) ,
            ]);


            return response()->json([
                'render' => \Zoroaster::minifyHtml($render) ,
                'resource' => $ResourceRequest->resourceClass ,
                'status' => 'ok' ,
            ]);


        }


    }
