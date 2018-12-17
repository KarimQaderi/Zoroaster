<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


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


        public function apply($resources , $ResourceRequest)
        {
            return $resources->paginate(((int)$ResourceRequest->Request()->{$ResourceRequest->resourceClass.'_perPage'} ?? 25))->appends(request()->all());
        }

        public function canSee($request)
        {
            return true;
        }
    }