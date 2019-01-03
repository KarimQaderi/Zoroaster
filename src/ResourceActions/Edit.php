<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Edit extends ShowOrHiden
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

        public function Authorization($request,$data)
        {
            return $request->Resource()->authorizedToUpdate($data);
        }
    }