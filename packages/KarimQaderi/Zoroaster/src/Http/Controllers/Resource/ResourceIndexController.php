<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers\Resource;

    use App\Http\Controllers\Controller;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\ResourceFilters\DefaultFilters;

    class ResourceIndexController extends Controller
    {
        public function handle(ResourceRequest $ResourceRequest)
        {

            $ResourceRequest->authorizeTo($ResourceRequest->Resource()->authorizeToIndex($ResourceRequest->Model()));

            $resources = $ResourceRequest->Model();

            $resources = $this->toQuery($resources , $ResourceRequest);

            return view('Zoroaster::resources.index')->with([
                'ResourceRequest' => $ResourceRequest ,
                'resourceClass' => $ResourceRequest->Resource() ,
                'model' => $ResourceRequest->Model() ,
                'resources' => $resources ,
                'fields' =>
                    $ResourceRequest->ResourceFields(function($field){
                        if($field !== null && $field->showOnIndex == true)
                            return true;
                        else
                            return false;
                    }) ,
            ]);

        }


        private function toQuery($resources , ResourceRequest $ResourceRequest)
        {

            if(request()->has('search'))
                $resources = $resources->where(function($q) use ($ResourceRequest){
                    foreach($ResourceRequest->Resource()->search as $field){
                        $q->orWhere($field , 'like' , '%' . request()->search . '%');
                    }
                });


            // Sort Table
            if(request()->has('sortable_direction') && request()->has('sortable_field'))
                $resources = $resources->orderBy(request()->sortable_field , request()->sortable_direction);


            // indexQuery
            if($ResourceRequest->Resource()->indexQuery($resources) !== null)
                $resources = $ResourceRequest->Resource()->indexQuery($resources);


            // filters
            $filters = (new DefaultFilters())->hendle();
            if($ResourceRequest->Resource()->filters() != null)
                $filters = array_merge($ResourceRequest->Resource()->filters() , $filters);

            foreach($filters as $filter){
                if($filter->canSee($ResourceRequest))
                    $resources = $filter->apply($resources , $ResourceRequest);
            }


            return $resources;

        }

    }