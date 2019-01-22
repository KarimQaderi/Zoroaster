<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\Boolean;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    abstract class BooleanFilter extends Filter
    {

        /**
         * The filter's component.
         *
         * @var string
         */
        public $component = 'boolean-filter';


        /**
         * @param ZoroasterResource $resource
         * @return \Illuminate\View\View | string
         */
        public function render($resource)
        {
            $keys = null;
            $data = [];
            foreach($this->options() as $value => $label){
                $keys[] = $this->getKey($value);
                $data = array_merge($data , [$this->getKey($value) => $this->request($value) ]);
            }

            return view('Zoroaster::resources.filters.boolean')
                ->with([
                    'getKey' => $this->getKey() ,
                    'keys' => $keys ,
                    'label' => $this->label() ,
                    'resource' => $resource ,
                    'boolean' => static::RenderForm([
                        $this->bool()
                    ] , (object)$data)
                ]);
        }


        private function bool()
        {
            $bool = null;
            foreach($this->options() as $value => $label){
                $bool[] = [
                    Boolean::make($label , $this->getKey($value)) ,
                ];
            }

            return $bool;

        }
    }
