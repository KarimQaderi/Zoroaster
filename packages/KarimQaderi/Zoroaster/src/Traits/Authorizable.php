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


        /**
         * @ Error
         */
        public function authorizeToIndex($model)
        {
            if(method_exists(Gate::getPolicyFor(static::newModel()) , 'index'))
            {
                $this->authorizeTo('index' , $model);
            }
        }

        /**
         * @return bool  true Or False
         */
        public function authorizedToIndex($model)
        {
            if(method_exists(Gate::getPolicyFor(static::newModel()) , 'index'))
            {
                return $this->authorizedTo('index' , $model);
            }
            else
                return true;
        }


        /**
         * @ Error
         */
        public function authorizeToShow($model)
        {
            $this->authorizeTo('view' , $model);
        }

        /**
         * @return bool  true Or False
         */
        public function authorizedToShow($model)
        {
            return $this->authorizedTo('view' , $model);
        }

        /**
         * @ Error
         */
        public function authorizeToCreate($model)
        {
            $this->authorizeTo('create' , $model);
        }

        /**
         * @return bool  true Or False
         */
        public function authorizedToCreate($model)
        {
            return $this->authorizedTo('create' , $model);
        }


        /**
         * @ Error
         */
        public function authorizeToUpdate($model)
        {
            $this->authorizeTo('update' , $model);
        }

        /**
         * @return bool  true Or False
         */
        public function authorizedToUpdate($model)
        {
            return $this->authorizedTo('update' , $model);
        }


        /**
         * @ Error
         */
        public function authorizeToDelete($model)
        {
            $this->authorizeTo('delete' , $model);
        }

        /**
         * @return bool  true Or False
         */
        public function authorizedToDelete($model)
        {
            return $this->authorizedTo('delete' , $model);
        }


        /**
         * @ Error
         */
        public function authorizeToForceDelete($model)
        {
            $this->authorizeTo('forceDelete' , $model);
        }

        /**
         * @return bool  true Or False
         */
        public function authorizedToForceDelete($model)
        {
            return $this->authorizedTo('forceDelete' , $model);
        }

        /**
         * @ Error
         */
        public function authorizeToRestore($model)
        {
            $this->authorizeTo('restore' , $model);
        }

        /**
         * @return bool  true Or False
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
            return static::authorizable() ? Gate::check($ability , $model) : true;
        }

    }