<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class DeleteAll extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromIndexTopLeft = true;

        public function render($resource , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.deleteAll')
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
            return $resource->authorizedToForceDelete($data);

        }


    }