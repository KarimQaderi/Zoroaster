<?php

    namespace KarimQaderi\Zoroaster;


    class Zoroaster
    {
        private static $resourcesByModel = [];
        private static $resources = [];

        public static function routes()
        {
            return require __DIR__ . '/../routes/routes.php';
        }

        public static function routeConfiguration()
        {
            return [
                'namespace' => '\KarimQaderi\Zoroaster\Http\Controllers' ,
                'domain' => config('Zoroaster.domain' , null) ,
                'as' => 'Zoroaster.' , // Route name
                'prefix' => 'Zoroaster' ,
                'middleware' => 'Zoroaster' ,
            ];
        }


        public static function newResource($resource)
        {
            $resource = 'App\\Zoroaster\\' . $resource;
            if(class_exists($resource))
                return new $resource;
            else
                return null;
        }

        public static function hasNewResourceByModelName($model)
        {
            if(empty($model)) return false;

            if(class_exists(\Zoroaster::getFullNameResourceByModelName($model)))
                return true;
            else
                return false;
        }

        public static function newResourceByModelName($modelName)
        {
          return  \Zoroaster::newResourceByModelName($modelName);
        }

        public static function newModel($model)
        {
            if(class_exists($model))
                return new $model;
            else
                return null;
        }

        public static function viewRender($view)
        {
           return $view->render();
        }


    }