<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class ForceDeleteAll extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromIndexTopLeft = true;

        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.forceDeletingAll')
                ->with([
                    'request' => $request ,
                    'data' => $data ,
                    'model' => $model ,
                    'field' => $field ,
                    'view' => $view ,
                ]);
        }

        /**
         * @param ResourceRequest $ResourceRequest
         * @return bool
         */
        public function Authorization($ResourceRequest , $data)
        {
            if(method_exists($ResourceRequest->Resource()->newModel() , 'isForceDeleting'))
                return $ResourceRequest->Resource()->authorizedToForceDelete($data);
            else
                return false;

        }


    }