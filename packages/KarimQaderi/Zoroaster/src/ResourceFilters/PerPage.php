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
            $name_perPage = $ResourceRequest->resourceClass . '_perPage';
            return $resources->paginate(((int)$ResourceRequest->Request()->{$name_perPage} ?? 25) , ['*'] , $ResourceRequest->resourceClass . '_Page');
        }

        public function canSee($request)
        {
            return true;
        }
    }