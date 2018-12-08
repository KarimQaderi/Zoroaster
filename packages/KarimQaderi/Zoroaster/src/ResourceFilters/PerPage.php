<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    class PerPage
    {

        public function render($request = null)
        {
            return view('Zoroaster::resources.filters.perPage')
                ->with([
                    'perPages' => ['25','50','100','300','500','1000'] ,
                ]);
        }


        public function handle($resources , $request)
        {
            return $resources->paginate(((int)$request->Request()->perPage ?? 25));
        }

        public function canSee($request)
        {
            return true;
        }
    }