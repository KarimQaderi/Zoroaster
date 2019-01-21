<?php

    namespace KarimQaderi\Zoroaster\Traits;

    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\ResourceFilters\DefaultFilters;

    trait ResourceIndexQuery
    {

        private $resourceClassRequest = null;

        /**
         * @param \Illuminate\Database\Eloquent\Model & \Illuminate\Database\Eloquent\Builder $resources
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\Database\Eloquent\Builder
         */
        private function toQuery($resources , $ResourceRequest)
        {

            $this->resourceClassRequest = $ResourceRequest->resourceClass;

            if($this->requestHas('search'))
                $resources = $resources->where(function($q) use ($ResourceRequest){
                    foreach($ResourceRequest->Resource()->search as $field){
                        $q->orWhere($field , 'like' , '%' . $this->request('search') . '%');
                    }
                });

            // Sort Table
            if($this->requestHas('sortable_direction') && $this->requestHas('sortable_field'))
                $resources = $resources->orderBy($this->request('sortable_field') , $this->request('sortable_direction'));


            // indexQuery
            if($ResourceRequest->Resource()->indexQuery($resources) !== null)
                $resources = $ResourceRequest->Resource()->indexQuery($resources);


            // filters
            $filters = (new DefaultFilters())->hendle();
            if($ResourceRequest->Resource()->filters() != null)
                $filters = array_merge($ResourceRequest->Resource()->filters() , $filters);

            foreach($filters as $filter){
                if($filter->authorizedToSee($ResourceRequest->Resource()))
                {
                    $filter->resourceClassRequest = $ResourceRequest->Resource()->uriKey();
                    $resources = $filter->apply($resources , $ResourceRequest->Resource());
                }
            }


            return $resources;

        }

        /**
         * @param $name
         * @return bool
         */
        private function requestHas($name)
        {
            return request()->has($this->resourceClassRequest . '_' . $name);
        }

        /**
         * @param $name
         * @return string
         */
        private function request($name)
        {
            return request()->{$this->resourceClassRequest . '_' . $name};
        }

    }