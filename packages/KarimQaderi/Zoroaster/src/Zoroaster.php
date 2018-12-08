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
            $resource = config('Zoroaster.Resources') . $resource;
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
            return \Zoroaster::newResourceByModelName($modelName);
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


        public static function BuilderWidgets($Sidebar)
        {
            $items = '';
            foreach($Sidebar as $field){
                switch(true){
                    case isset($field->data):
                        $items .= $field->viewForm(self::BuilderWidgets($field->data) , $field);
                        break;
                    default:
                        $items .= $field->Render($field);
                        break;
                }
            }

            return $items;
        }


        public static function BuilderSidebar($Sidebar)
        {
            $items = '';
            foreach($Sidebar as $field){
                switch(true){
                    case isset($field->data):
                        $field->data = (self::BuilderSidebar($field->data));
                        $items .= $field->Render($field);
                        break;
                    default:
                        if(isset($field->Access)){
                            if($field->Access)
                                $items .= $field->Render($field);
                        } else
                            $items .= $field->Render($field);
                        break;
                }
            }

            return $items;
        }




    }