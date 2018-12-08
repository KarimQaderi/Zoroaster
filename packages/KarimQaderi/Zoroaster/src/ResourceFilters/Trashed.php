<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    class Trashed
    {

        public function render($request = null)
        {
            return view('Zoroaster::resources.filters.trashed')
                ->with([
                    'FilterTrashed' => ['' => '—' , 'all' => 'همه' , 'only' => 'فقط زباله'] ,
                ]);
        }


        public function handle($resources , $request)
        {

            if(request()->has('FilterTrashed'))
                switch(request()->FilterTrashed){
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
            if(method_exists($request->Model() , 'isForceDeleting'))
                return true;
            else
                return false;
        }
    }