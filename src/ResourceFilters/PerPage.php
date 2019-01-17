<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters\Filter;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class PerPage extends Filter
    {

        private $ResourceRequest;

        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\View\View
         */
        public function render($ResourceRequest)
        {
            $this->ResourceRequest = $ResourceRequest;

            return view('Zoroaster::resources.filters.perPage')
                ->with($this->options());
        }

        /**
         * Get the filter's available options.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */
        public function options()
        {
            return [
                'perPages' => ['25' , '50' , '100' , '300' , '500' , '1000'] ,
                'ResourceRequest' => $this->ResourceRequest ,
                'getKey' => $this->getKey() ,
            ];

        }

        /**
         * @param Model & Builder $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        public function apply($resource , $ResourceRequest)
        {
            return $resource->paginate(((int)$this->Request() ?? 25) , ['*'] , $this->resourceClassRequest . '_Page');
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