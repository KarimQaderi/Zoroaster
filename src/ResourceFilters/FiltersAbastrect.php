<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    abstract class FiltersAbastrect
    {

        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        abstract public function render($ResourceRequest);

        /**
         *  @param Model & Builder $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        abstract public function apply($resource , $ResourceRequest);


        /**
         * @param $ResourceRequest ResourceRequest
         * @return bool
         */
        abstract public function canSee($ResourceRequest);
    }