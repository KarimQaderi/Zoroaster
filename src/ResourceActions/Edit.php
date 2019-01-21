<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;

    class Edit extends ResourceActionsAbastract
    {
        public $component = 'edit';

        public $showFromDetail = true;
        public $showFromIndex = true;

        public function render($resource , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.edit')
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
        public function Authorization($resource,$data)
        {
            return $resource->authorizedToUpdate($data);
        }
    }