<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

    use Closure;
    use Illuminate\Database\Eloquent\Builder;
    use Illuminate\Database\Eloquent\Model;
    use JsonSerializable;
    use Illuminate\Http\Request;
    use Illuminate\Container\Container;
    use KarimQaderi\Zoroaster\Fields\Extend\ProxiesCanSeeToGate;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;


    abstract class Filter
    {
        use ProxiesCanSeeToGate;


        /**
         * The displayable name of the action.
         *
         * @var string
         */
        public $name;

        /**
         * The filter's component.
         *
         * @var string
         */
        public $component = 'select-filter';


        public $resourceClassRequest = null;

        public function __construct()
        {
            $this->resourceClassRequest = \Zoroaster::getParameterCurrentRoute('resource');
        }

        /**
         * @param ResourceRequest $ResourceRequest
         * @return \Illuminate\View\View | string
         */
        abstract public function render($ResourceRequest);

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
        public function name()
        {
            return $this->name ?? class_basename($this);
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
    }
