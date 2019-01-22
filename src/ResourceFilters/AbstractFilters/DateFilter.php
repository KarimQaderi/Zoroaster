<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\DateTime;

    abstract class DateFilter extends Filter
    {
        /**
         * The filter's component.
         *
         * @var string
         */
        public $component = 'date-filter';


        /**
         * @param ZoroasterResource $resource
         * @return \Illuminate\View\View | string
         */
        public function render($resource)
        {
            $data = [$this->getKey() => $this->request()];

            return view('Zoroaster::resources.filters.render')
                ->with([
                    'getKey' => $this->getKey() ,
                    'label' => $this->label() ,
                    'resource' => $resource ,
                    'boolean' => static::RenderForm([
                        DateTime::make('' , $this->getKey())
                    ] , (object)$data)
                ]);
        }
    }
