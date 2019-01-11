<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class ForceDelete extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromDetail = true;


        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.forceDelete')
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