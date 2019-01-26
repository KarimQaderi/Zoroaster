<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\Select;
    use KarimQaderi\Zoroaster\ResourceFilters\ProxiesCanSeeToGate;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;


    abstract class Filter
    {
        use ProxiesCanSeeToGate , \KarimQaderi\Zoroaster\Traits\Builder;


        /**
         * The displayable name of the action.
         *
         * @var string
         */
        public $label;

        public $resourceClassRequest = null;

        public function __construct()
        {

        }

        /**
         * Apply the filter to the given query.
         *
         * @param Model & Builder $resource
         * @param ResourceRequest $ResourceRequest
         * @return Model
         */
        abstract public function apply($resource , $ResourceRequest);

        /**
         * Get the filter's available options.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */
        abstract public function options();


        /**
         * Get the displayable name of the filter.
         *
         * @return string
         */
        public function label()
        {
            return $this->label ?? class_basename($this);
        }


        /**
         * @param $name
         * @return bool
         */
        public function requestHas($key = null)
        {
            return request()->has($this->getKey($key));
        }

        /**
         * @param $name
         * @return mixed
         */
        public function request($key = null)
        {
            $request = request()->{$this->getKey($key)};

            if($request == 'true' || $request == 'on') return true;
            if($request == 'false' || $request == 'off') return false;

            return $request;
        }


        /**
         * @param $name
         * @return mixed
         */
        public function getKey($name = null)
        {
            return $this->resourceClassRequest . '_' . class_basename($this) . ($name ? '_' . $name : null);
        }

        /**
         * @param $name
         * @return mixed
         */
        public function getValue()
        {
            $values = [];
            foreach(request()->all() as $key => $value){
                if(starts_with($key , $this->getKey()))
                    $values = array_merge($values , [$key => $value]);
            }
            return $values;
        }


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
                    'render' => static::RenderForm([
                        Select::make('' , $this->getKey())->options($this->options())
                    ] , (object)$data)
                ]);
        }

    }
