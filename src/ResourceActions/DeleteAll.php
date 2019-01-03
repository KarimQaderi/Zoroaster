<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class DeleteAll extends ShowOrHiden
    {

        public $component = 'delete';

        public $showFromIndexTopLeft = true;

        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.deleteAll')
                ->with([
                    'request' => $request ,
                    'data' => $data ,
                    'model' => $model ,
                    'field' => $field ,
                    'view' => $view ,
                ]);
        }

        public function Authorization($request , $data)
        {
            return $request->Resource()->authorizedToForceDelete($data);

        }


    }