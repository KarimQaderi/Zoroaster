<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class PerPage
    {


        public function render($ResourceRequest)
        {
            return view('Zoroaster::resources.filters.perPage')
                ->with([
                    'perPages' => ['25' , '50' , '100' , '300' , '500' , '1000'] ,
                    'ResourceRequest' => $ResourceRequest ,
                ]);
        }

        /**
         * @param Model $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        public function apply($resource , $ResourceRequest)
        {
            $name_perPage = $ResourceRequest->resourceClass . '_perPage';
            return $resource->paginate(((int)$ResourceRequest->Request()->{$name_perPage} ?? 25) , ['*'] , $ResourceRequest->resourceClass . '_Page');
        }

        /**
         * @param $ResourceRequest ResourceRequest
         * @return bool
         */
        public function canSee($ResourceRequest)
        {
            return true;
        }
    }