<?php

    namespace KarimQaderi\Zoroaster\Traits;

    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\ResourceFilters\DefaultFilters;

    trait ResourceIndexQuery
    {

        private function toQuery($resources , ResourceRequest $ResourceRequest)
        {

            if(request()->has($ResourceRequest->resourceClass . '_search'))
                $resources = $resources->where(function($q) use ($ResourceRequest)
                {
                    foreach($ResourceRequest->Resource()->search as $field)
                    {
                        $q->orWhere($field , 'like' , '%' . request()->{$ResourceRequest->resourceClass . '_search'} . '%');
                    }
                });

            // Sort Table
            if(request()->has($ResourceRequest->resourceClass . '_sortable_direction') && request()->has($ResourceRequest->resourceClass . '_sortable_field'))
                $resources = $resources->orderBy(request()->{$ResourceRequest->resourceClass . '_sortable_field'} , request()->{$ResourceRequest->resourceClass . '_sortable_direction'});


            // indexQuery
            if($ResourceRequest->Resource()->indexQuery($resources) !== null)
                $resources = $ResourceRequest->Resource()->indexQuery($resources);


            // filters
            $filters = (new DefaultFilters())->hendle();
            if($ResourceRequest->Resource()->filters() != null)
                $filters = array_merge($ResourceRequest->Resource()->filters() , $filters);

            foreach($filters as $filter)
            {
                if($filter->canSee($ResourceRequest))
                    $resources = $filter->apply($resources , $ResourceRequest);
            }


            return $resources;

        }

    }