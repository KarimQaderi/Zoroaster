<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class Edit extends ResourceActionsAbastract
    {
        public $component = 'edit';

        public $showFromDetail = true;
        public $showFromIndex = true;

        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.edit')
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
        public function Authorization($ResourceRequest,$data)
        {
            return $ResourceRequest->Resource()->authorizedToUpdate($data);
        }
    }