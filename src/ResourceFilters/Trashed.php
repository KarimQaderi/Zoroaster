<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;

    class Trashed extends FiltersAbastrect
    {

        /**
         * @param $ResourceRequest
         * @return \Illuminate\View\View
         */
        public function render($ResourceRequest)
        {
            return view('Zoroaster::resources.filters.trashed')
                ->with([
                    'FilterTrashed' => ['' => '—' , 'all' => 'همه' , 'only' => 'فقط زباله'] ,
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

            if($this->requestHas('FilterTrashed'))
                switch($this->request('FilterTrashed')){
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