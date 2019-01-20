<?php

    namespace KarimQaderi\Zoroaster;


    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Query\Builder;

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
         * @param  array $resources
         */
        public static function resources(array $resources)
        {
            static::$resources = array_merge(static::$resources , $resources);
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
            static::$SidebarMenus = array_merge(static::$SidebarMenus , $SidebarMenus);
        }

        /**
         * Register the given styles.
         *
         * @param  array | string $styles
         */
        public static function styles($styles)
        {
            static::$styles = array_merge(static::$styles , is_array($styles)? $styles : [$styles]);
        }

        /**
         * Register the given scripts.
         *
         * @param  array | string $scripts
         */
        public static function scripts($scripts)
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