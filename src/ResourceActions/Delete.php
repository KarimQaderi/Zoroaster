<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class Delete extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromDetail = true;
        public $showFromIndex = true;

        /**
         * @return \Illuminate\View\View
         */
        public function render($resource , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.delete')
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
            if(array_key_exists('deleted_at' , $data->attributesToArray())){
                if($data->deleted_at !== null)
                    return false;
                else
                    return $resource->authorizedToDelete($data);
            } else
                return $resource->authorizedToForceDelete($data);

        }


    }