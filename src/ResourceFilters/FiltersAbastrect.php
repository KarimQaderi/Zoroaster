<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    abstract class FiltersAbastrect
    {

        private $resourceClassRequest = null;

        public function __construct()
        {
            $this->resourceClassRequest = \Zoroaster::getCurrentRouteResource();
        }

        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        abstract public function render($ResourceRequest);

        /**
         * @param Model & Builder $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        abstract public function apply($resource , $ResourceRequest);


        /**
         * @param $ResourceRequest ResourceRequest
         * @return bool
         */
        abstract public function canSee($ResourceRequest);

        /**
         * @param $name
         * @return bool
         */
        public function requestHas($key)
        {
            return request()->has($this->resourceClassRequest . '_' . $key);
        }

        /**
         * @param $name
         * @return string
         */
        public function request($key = null)
        {
            if($key == null) return request();

            return request()->{$this->resourceClassRequest . '_' . $key};
        }
    }