<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    abstract class FiltersAbastrect
    {

        public $resourceClassRequest = null;

        public function __construct()
        {
            $this->resourceClassRequest = \Zoroaster::getParameterCurrentRoute('resource');
        }

        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\View\View
         */
        abstract public function render($ResourceRequest);

        /**
         * @param Model & Builder $query
         * @param ResourceRequest $ResourceRequest
         * @return Builder
         */
        abstract public function apply($query , $ResourceRequest);


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