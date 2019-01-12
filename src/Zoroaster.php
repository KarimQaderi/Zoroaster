<?php

    namespace KarimQaderi\Zoroaster;


    use Illuminate\Database\Eloquent\Model;
    use phpDocumentor\Reflection\Types\Null_;

    class Zoroaster
    {

        private static $resourcesByModel = [];
        private static $resources = [];

        /**
         * Register the given resources.
         *
         * @param  array $resources
         * @return static
         */
        public static function resources(array $resources)
        {
            static::$resources = array_merge(static::$resources , $resources);

            return new static;
        }

        public static function routeConfiguration($unset = null)
        {
            $var = [
                'namespace' => '\KarimQaderi\Zoroaster\Http\Controllers' ,
                'domain' => config('Zoroaster.domain' , null) ,
                'as' => 'Zoroaster.' , // Route name
                'prefix' => config('Zoroaster.path' , 'Zoroaster') ,
                'middleware' => ['Zoroaster' , 'can:Zoroaster'] ,
            ];

            if(is_string($unset))
                unset($var[$unset]);

            if(is_array($unset))
                foreach($unset as $un)
                    unset($var[$un]);

            return $var;
        }

        /**
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource
         */
        public static function newResource($resource)
        {
            $resource = config('Zoroaster.Resources') . $resource;
            return class_exists($resource) ? new $resource : null;
        }

        public static function hasNewResourceByModelName($model)
        {
            return !empty($model) && class_exists(\Zoroaster::getFullNameResourceByModelName($model)) ? true : false;
        }

        /**
         * @return \KarimQaderi\Zoroaster\Resource
         */
        public static function newResourceByModelName($modelName)
        {
            return \Zoroaster::newResourceByModelName($modelName);
        }

        /**
         * @return Model
         */
        public static function newModel($model)
        {
            return class_exists($model) ? new $model : null;
        }

        public static function viewRender($view)
        {
            return $view->render();
        }


        public static function findAllResource()
        {
            $namespace = str_replace_last('\\' , '' , config('Zoroaster.Resources'));
            $namespace = str_replace('\\' , '/' , $namespace);

            $Re = str_replace_first('App' , 'app' , $namespace);

            return self::finderAllClassByPath($namespace , $Re);
        }

        public static function finderAllClassByPath($namespace = '' , $path = '')
        {
            $finder = new \Symfony\Component\Finder\Finder();
            $finder->files()->in(base_path($path));

            $find = [];
            foreach($finder as $file){
                $ns = $namespace;
                if($relativePath = $file->getRelativePath()){
                    $ns .= '/' . strtr($relativePath , '/' , '/');
                }
                $class = $ns . '/' . $file->getBasename('.php');

                $r = new \ReflectionClass(str_replace('/' , '\\' , $class));

                $find[] = $r->getName();

            }

            return $find;
        }


    }