<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;

    class Restore extends ResourceActionsAbastract
    {
        public $component = 'show';

        public $showFromIndex = true;
        public $showFromDetail = true;

        public function render($resource , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.restore')
                ->with([
                    'resource' => $resource ,
                    'data' => $data ,
                    'model' => $model ,
                    'field' => $field ,
                    'view' => $view ,
                ]);
        }

        /**
         * @param ZoroasterResource $resource
         * @return bool
         */
        public function Authorization($resource , $data)
        {
            if(method_exists($resource->newModel() , 'isForceDeleting') && $data->deleted_at != null)
                return $resource->authorizedToRestore($data);
            else
                return false;
        }

    }