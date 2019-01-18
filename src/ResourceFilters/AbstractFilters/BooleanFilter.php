<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

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
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\View\View | string
         */
        public function render($ResourceRequest)
        {
            $keys = null;
            $data = [];
            foreach($this->options() as $value => $label){
                $keys[] = $this->getKey($value);
                $data = array_merge($data , [$this->getKey($value) => request()->{$this->getKey($value)} == "true" ? true : false]);
            }

            return view('Zoroaster::resources.filters.boolean')
                ->with([
                    'getKey' => $this->getKey() ,
                    'keys' => $keys ,
                    'label' => $this->label() ,
                    'ResourceRequest' => $ResourceRequest ,
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
