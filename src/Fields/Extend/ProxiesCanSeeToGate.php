<?php

    namespace KarimQaderi\Zoroaster\Fields\Extend;

    use Illuminate\Support\Facades\Auth;

    trait ProxiesCanSeeToGate
    {
        /**
         * The callback used to authorize viewing.
         *
         * @var \Closure|null
         */
        public $seeCallback;

        public function authorizedToSee()
        {
            if(is_callable($this->seeCallback))
                if(call_user_func($this->seeCallback))
                    return true;
                else
                    return false;

            return true;
        }

        /**
         * Set the callback to be run to authorize viewing .
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
         * Set the callback to be run to authorize viewing
         *
         * @param  bool $bool
         * @return $this
         */
        public function canSeeByBool($bool)
        {
            $this->seeCallback = function() use ($bool){
                return $bool;
            };

            return $this;
        }

        public function gate($ability , $arguments = [])
        {
            $this->seeCallback = function() use ($ability , $arguments){
                return Auth::user()->can($ability , $arguments);
            };

            return $this;
        }
    }
