<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters\Filter;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class PerPage extends Filter
    {

        public $label = "تعداد در هر صفحه";

        /**
         * Get the filter's available options.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */
        public function options()
        {
            return [
                '25' => '25' ,
                '50' => '50' ,
                '100' => '100' ,
                '300' => '300' ,
                '500' => '500' ,
                '1000' => '1000'
            ];

        }

        /**
         * @param Model & Builder $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        public function apply($resource , $ResourceRequest)
        {
            return $resource->paginate(((int)$this->Request() ?? 25) , ['*'] , $ResourceRequest->resourceClass.'_Page');
        }
    }