<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    class Trashed
    {

        public function render($ResourceRequest)
        {
            return view('Zoroaster::resources.filters.trashed')
                ->with([
                    'FilterTrashed' => ['' => '—' , 'all' => 'همه' , 'only' => 'فقط زباله'] ,
                    'ResourceRequest' => $ResourceRequest,
                ]);
        }


        public function apply($resources , $ResourceRequest)
        {

            if(request()->has($ResourceRequest->resourceClass . '_FilterTrashed'))
                switch(request()->{$ResourceRequest->resourceClass . '_FilterTrashed'})
                {
                    case '':
                        break;
                    case 'all':
                        $resources = $resources->withTrashed();
                        break;
                    case 'only':
                        $resources = $resources->onlyTrashed();
                        break;
                }

            return $resources;
        }

        public function canSee($request)
        {
            if(method_exists($request->newModel() , 'isForceDeleting'))
                return true;
            else
                return false;
        }
    }