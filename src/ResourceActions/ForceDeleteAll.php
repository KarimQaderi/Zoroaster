<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class ForceDeleteAll extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromIndexTopLeft = true;

        public function render($resource , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.forceDeletingAll')
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
            if(method_exists($resource->newModel() , 'isForceDeleting'))
                return $resource->authorizedToForceDelete($data);
            else
                return false;

        }


    }