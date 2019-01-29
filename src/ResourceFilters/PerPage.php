<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters;


    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
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
                '15' => '15' ,
                '25' => '25' ,
                '50' => '50' ,
                '100' => '100' ,
                '300' => '300' ,
                '500' => '500' ,
                '1000' => '1000'
            ];

        }

        /**
         * @param Model & Builder $query
         * @param ZoroasterResource $ZoroasterResource
         * @return Builder
         */
        public function apply($query , $ZoroasterResource)
        {
            return $query->paginate(((int)$this->Request() ?? 25) , ['*'] , $ZoroasterResource->uriKey().'_Page');
        }
    }