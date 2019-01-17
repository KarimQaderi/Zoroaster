<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters\Filter;

    class Trashed extends Filter
    {

        private $ResourceRequest;

        /**
         * @param $ResourceRequest
         * @return \Illuminate\View\View
         */
        public function render($ResourceRequest)
        {
            $this->ResourceRequest = $ResourceRequest;

            return view('Zoroaster::resources.filters.trashed')
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
                'FilterTrashed' => ['' => '—' , 'all' => 'همه' , 'only' => 'فقط زباله'] ,
                'ResourceRequest' => $this->ResourceRequest ,
                'getKey' => $this->getKey() ,
            ];
        }

        /**
         * @param Model $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        public function apply($resource , $ResourceRequest)
        {

            if($this->requestHas())
                switch($this->request()){
                    case '':
                        break;
                    case 'all':
                        $resource = $resource->withTrashed();
                        break;
                    case 'only':
                        $resource = $resource->onlyTrashed();
                        break;
                }

            return $resource;
        }

        /**
         * @param $ResourceRequest ResourceRequest
         * @return bool
         */
        public function canSee($ResourceRequest)
        {
            if(method_exists($ResourceRequest->Resource()->newModel() , 'isForceDeleting'))
                return true;
            else
                return false;
        }


    }