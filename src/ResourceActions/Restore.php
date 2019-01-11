<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class Restore extends ResourceActionsAbastract
    {
        public $component = 'show';

        public $showFromIndex = true;
        public $showFromDetail = true;

        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.restore')
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
            if(method_exists($ResourceRequest->Resource()->newModel() , 'isForceDeleting') && $data->deleted_at != null)
                return $ResourceRequest->Resource()->authorizedToRestore($data);
            else
                return false;
        }

    }