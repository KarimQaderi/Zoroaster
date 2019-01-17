<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

    use function GuzzleHttp\Promise\all;
    use Illuminate\Http\Request;
    use Illuminate\Container\Container;
    use KarimQaderi\Zoroaster\Fields\Boolean;
    use KarimQaderi\Zoroaster\Traits\Builder;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    abstract class BooleanFilter extends Filter
    {
        use Builder;
        /**
         * The filter's component.
         *
         * @var string
         */
        public $component = 'boolean-filter';

        /**
         * Set the default options for the filter.
         *
         * @return array
         */
        public function default()
        {
            $container = Container::getInstance();

            return collect($this->options($container->make(Request::class)))->values()->flatMap(function($option){
                return [$option => false];
            })->all();
        }

        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\View\View
         */
        public function render($ResourceRequest)
        {
            $keys = null;
            $data = [];
            foreach($this->options() as $value => $label){
                $keys[] = $this->getKey($value);
                $data = array_merge($data,[$this->getKey($value) => request()->{$this->getKey($value)}=="true" ? true : false]);
            }

            return view('Zoroaster::resources.filters.boolean')
                ->with([
                    'getKey' => $this->getKey() ,
                    'keys' => $keys ,
                    'name' => $this->name() ,
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
