<?php

    namespace KarimQaderi\Zoroaster\ResourceFilters\AbstractFilters;

    use Closure;
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

        /**
         * The callback used to authorize viewing the filter.
         *
         * @var \Closure|null
         */
        public $seeCallback;


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
         * @param  \Illuminate\Database\Eloquent\Builder $query
         * @param  mixed $value
         * @return \Illuminate\Database\Eloquent\Builder
         */
        abstract public function apply($query , $value);

        /**
         * Get the filter's available options.
         *
         * @param  \Illuminate\Http\Request $request
         * @return array
         */
        abstract public function options();

        /**
         * Determine if the filter should be available for the given request.
         *
         * @param  \Illuminate\Http\Request $request
         * @return bool
         */
        public function authorizedToSee(Request $request)
        {
            return $this->seeCallback ? call_user_func($this->seeCallback , $request) : true;
        }

        /**
         * Set the callback to be run to authorize viewing the filter.
         *
         * @param  \Closure $callback
         * @return $this
         */
        public function canSee($callback)
        {
            $this->seeCallback = $callback;

            return $this;
        }

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
         * Set the default options for the filter.
         *
         * @return array
         */
        public function default()
        {
            return [];
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
            return request()->{$this->getKey($key)};
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
