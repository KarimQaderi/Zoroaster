<?php

    namespace KarimQaderi\Zoroaster\Traits;


    use Illuminate\Auth\Access\AuthorizationException;
    use Illuminate\Support\Facades\Gate;

    trait Authorizable
    {

        public static function authorizable()
        {
            return !is_null(Gate::getPolicyFor(static::newModel()));
        }

        public function getClass()
        {
            return strtolower(class_basename($this));
        }

        /**
         * @param $model
         */
        public function authorizeToIndex($model)
        {
            $this->authorizeTo('index' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToIndex($model)
        {
            return $this->authorizedTo('index' , $model);
        }


        /**
         * @param $model
         */
        public function authorizeToShow($model)
        {
            $this->authorizeTo('show' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToShow($model)
        {
            return $this->authorizedTo('show' , $model);
        }

        /**
         * @param $model
         */
        public function authorizeToCreate($model)
        {
            $this->authorizeTo('create' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToCreate($model)
        {
            return $this->authorizedTo('create' , $model);
        }


        /**
         * @param $model
         */
        public function authorizeToUpdate($model)
        {
            $this->authorizeTo('update' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToUpdate($model)
        {
            return $this->authorizedTo('update' , $model);
        }


        /**
         * @param $model
         */
        public function authorizeToDelete($model)
        {
            $this->authorizeTo('delete' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToDelete($model)
        {
            return $this->authorizedTo('delete' , $model);
        }


        /**
         * @param $model
         */
        public function authorizeToForceDelete($model)
        {
            $this->authorizeTo('forceDelete' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToForceDelete($model)
        {
            return $this->authorizedTo('forceDelete' , $model);
        }


        /**
         * @param $model
         */
        public function authorizeToRestore($model)
        {
            $this->authorizeTo('restore' , $model);
        }

        /**
         * @return bool
         */
        public function authorizedToRestore($model)
        {
            return $this->authorizedTo('restore' , $model);
        }



        public function authorizeTo($ability , $model)
        {
            throw_unless($this->authorizedTo($ability , $model) , AuthorizationException::class);
        }

        public function authorizedTo($ability , $model)
        {
            if(config('Zoroaster.permission'))
                return auth()->user()->hasPermission($ability . '-' . $this->getClass());

            if(method_exists(Gate::getPolicyFor(static::newModel()) , $ability))
                return static::authorizable() ? Gate::check($ability , $model) : true;
            else
                return true;
        }


    }