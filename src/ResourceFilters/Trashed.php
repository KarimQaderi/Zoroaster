<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Http\Requests\ResourceRequest;
    use KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters\Filter;

    class Trashed extends Filter
    {

        public $label = "زباله";

        /**
         * Get the filter's available options.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */
        public function options()
        {
            return ['' => '—' , 'all' => 'همه' , 'only' => 'فقط زباله'];
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

        public function authorizedToSee($ResourceRequest)
        {
            if(method_exists($ResourceRequest->Resource()->newModel() , 'isForceDeleting'))
                return true;
            else
                return false;
        }


    }