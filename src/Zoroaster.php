<?php

    namespace KarimQaderi\Zoroaster;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Support\Str;
    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use Symfony\Component\Finder\Finder;

    class Zoroaster
    {

        /**
         * resources همه
         *
         * @var array
         */
        public static $resources = [];

        /**
         * resources همه
         *
         * @var array
         */
        public static $SidebarMenus = [];

        /**
         * scripts همه
         *
         * @var array
         */
        public static $scripts = [];

        /**
         * CSS همه
         *
         * @var array
         */
        public static $styles = [];


        /**
         * jsRoute
         *
         * @var array
         */
        public static $jsRoute = [];


        /**
         * Register the given resources.
         *
         * @param  array | string $resources
         */
        public static function resources($resources)
        {
            static::$resources = array_merge(static::$resources , is_array($resources) ? $resources : [$resources]);
        }

        /**
         * Register all of the resource classes in the given directory.
         *
         * @param  string $directory
         * @return void
         */
        public static function resourcesIn($directory)
        {
            Zoroaster::resources(Zoroaster::findAllResource($directory));
        }


        /**
         * Register the given jsRoute.
         *
         * @param  array | string $jsRoute
         */
        public static function jsRoute($jsRoute)
        {
            static::$jsRoute = array_merge(static::$jsRoute , is_array($jsRoute) ? $jsRoute : [$jsRoute]);
        }


        /**
         * Register the given SidebarMenus.
         *
         * @param  array
         */
        public static function SidebarMenus(array $SidebarMenus)
        {
            static::$SidebarMenus = array_merge($SidebarMenus , static::$SidebarMenus);
        }

        /**
         * Register the given styles.
         *
         * @param  array | string $styles
         */
        public static function style($styles)
        {
            static::$styles = array_merge(static::$styles , is_array($styles) ? $styles : [$styles]);
        }

        /**
         * Register the given scripts.
         *
         * @param  array | string $scripts
         */
        public static function script($scripts)
        {
            static::$scripts = array_merge(static::$scripts , is_array($scripts) ? $scripts : [$scripts]);
        }


        /**
         * resourceFindByUriKey
         *
         * @param  string $uriKey
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource | null
         */
        public static function resourceFindByUriKey($uriKey)
        {
            foreach(static::$resources as $resource){
                $new = new $resource;
                if($new->uriKey() == $uriKey)
                    return $new;
            }

            return null;
        }


        /**
         * resourceFindByUriKey
         *
         * @param  string $uriKey
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource | null
         */
        public static function resourceFindByModel($model)
        {
            foreach(static::$resources as $resource){
                if(class_basename(($new = new $resource)->getModel()) == $model)
                    return $new;
            }

            return null;
        }

        /**
         * resourceFindByUriKey
         *
         * @param  string $uriKey
         * @return \KarimQaderi\Zoroaster\Abstracts\ZoroasterResource | null
         */
        public static function resourceFindByUriKeyOrFail($uriKey)
        {
            return self::resourceFindByUriKey($uriKey);

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
            foreach(static::$resources as $resource){
                if(class_basename(($new = new $resource)->getModel()) == $model)
                    return true;
            }

            return false;
        }

        /**
         * @return Abstracts\ZoroasterResource|Resource
         */
        public static function newResourceByModelName($modelName)
        {
            return \Zoroaster::newResourceByModelName($modelName);
        }

        /**
         * @return Builder & Model
         */
        public static function newModel($model)
        {
            return class_exists($model) ? new $model : null;
        }

        /**
         * @return Builder & Model
         */
        public static function newModelOrFail($model)
        {
            if(($model = static::newModel($model)) == null)
                throw new \Exception('The model was not found');

            return $model;
        }


        public static function findAllResource($directory)
        {

            $namespace = app()->getNamespace();

            $resources = [];

            if(!is_null($directory))
                foreach((new Finder())->in($directory)->files() as $resource){
                    $resource = $namespace . str_replace(
                            ['/' , '.php'] ,
                            ['\\' , ''] ,
                            Str::after($resource->getPathname() , app_path() . DIRECTORY_SEPARATOR)
                        );


                    if(is_subclass_of($resource , ZoroasterResource::class) &&
                        !(new \ReflectionClass($resource))->isAbstract()){
                        $resources[] = $resource;
                    }

                }

            return $resources;

        }

    }