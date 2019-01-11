<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    use KarimQaderi\Zoroaster\ResourceActions\Other\ResourceActionsAbastract;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    class Delete extends ResourceActionsAbastract
    {

        public $component = 'delete';

        public $showFromDetail = true;
        public $showFromIndex = true;

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.delete')
                ->with([
                    'request' => $request ,
                    'data' => $data ,
                    'model' => $model ,
                    'field' => $field ,
                    'view' => $view ,
                ]);
        }

        /**
         * @param $ResourceRequest ResourceRequest
         * @return bool
         */
        public function Authorization($ResourceRequest , $data)
        {
            if(array_key_exists('deleted_at' , $data->attributesToArray())){
                if($data->deleted_at !== null)
                    return false;
                else
                    return $ResourceRequest->Resource()->authorizedToDelete($data);
            } else
                return $ResourceRequest->Resource()->authorizedToForceDelete($data);

        }


    }