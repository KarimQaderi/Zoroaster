<?php

    namespace KarimQaderi\Zoroaster\Traits;


    use Illuminate\Auth\Access\AuthorizationException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Gate;

    trait Authorizable
    {

        public static function authorizable()
        {
            return !is_null(Gate::getPolicyFor(static::newModel()));
        }


        /**
         * @return bool
         */
        public function authorizeToIndex($model)
        {
            if(!static::authorizable())
            {
                return  Gate::check('index' , $this->resource);
            }

            if(method_exists(Gate::getPolicyFor(static::newModel()) , 'index'))
            {
                $this->authorizeTo(request() , 'index');
            }
        }


        /**
         * @return bool
         */
        public function authorizeToShow($data)
        {
            return true;
        }


        /**
         * @return bool
         */
        public function authorizeToCreate($model)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizeToUpdate($data)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizeToDelete($data)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizeToForceDelete($data)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizedToAdd($data)
        {
            return true;
        }

        /**
         * @return bool
         */
        public function authorizedToRestore($data)
        {
            return true;
        }

        public function authorizeTo(Request $request , $ability)
        {
            throw_unless($this->authorizedTo($request , $ability) , AuthorizationException::class);
        }

        public function authorizedTo(Request $request , $ability)
        {
            return static::authorizable() ? Gate::check($ability , $this->resource) : true;
        }

    }