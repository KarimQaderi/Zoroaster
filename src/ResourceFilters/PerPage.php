<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class PerPage extends FiltersAbastrect
    {


        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\View\View
         */
        public function render($ResourceRequest)
        {
            return view('Zoroaster::resources.filters.perPage')
                ->with([
                    'perPages' => ['25' , '50' , '100' , '300' , '500' , '1000'] ,
                    'ResourceRequest' => $ResourceRequest ,
                ]);
        }

        /**
         * @param Model & Builder $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        public function apply($resource , $ResourceRequest)
        {
            return $resource->paginate(((int)$this->Request('perPage') ?? 25) , ['*'] , $this->resourceClassRequest . '_Page');
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