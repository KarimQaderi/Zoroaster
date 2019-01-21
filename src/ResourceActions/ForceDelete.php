<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class ForceDelete extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromDetail = true;


        public function render($resource , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.forceDelete')
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