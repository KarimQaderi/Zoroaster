<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Exceptions\NotFoundField;
    use KarimQaderi\Zoroaster\Exceptions\NotFoundRelationship;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\Traits\ResourceIndexQuery;

    class ResourceIndexRelationshipController extends Controller
    {
        use ResourceIndexQuery;

        public function handle(ResourceRequest $ResourceRequest)
        {

            $ResourceRequest->Resource()->authorizeToIndex($ResourceRequest->Resource()->newModel());


            $resources = $ResourceRequest->Resource()->newModel();

            $HasMany = \Zoroaster::getFieldResource(request()->viaRelationship , request()->viaRelationshipFieldName);
            if(is_null($HasMany)) throw (new NotFoundField())->setField(request()->viaRelationshipFieldName);

            // relationshipType
            switch(request()->relationshipType){
                case 'HasMany':
                    $resources = $this->toQuery($resources->where($HasMany->relationship_id , request()->viaResourceId) , $ResourceRequest);
                    break;
                case 'HasOne':
                    $resources = $resources->where($HasMany->relationship_id , request()->viaResourceId)->limit(1)->get();
                    break;
                default:
                    throw (new NotFoundRelationship())->setRelationship(request()->relationshipType);
                    break;
            }


            $render = null;
            $render .= view('Zoroaster::resources.index-resource')->with([
                'relationshipType' => request()->relationshipType ,
                'ResourceRequest' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Resource()->newModel() ,
                'resources' => $resources ,
                'fields' =>
                    $ResourceRequest->ResourceFields(function($field){
                        if($field !== null && $field->showOnIndex == true)
                            return true;
                        else
                            return false;
                    }) ,
            ]);

            return response()->json([
                'render' => \Zoroaster::minifyHtml($render) ,
                'resource' => $ResourceRequest->resourceClass ,
                'status' => 'ok' ,
            ]);


        }


    }