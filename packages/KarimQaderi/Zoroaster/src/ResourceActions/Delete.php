<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Delete extends Button
    {

        public $component = 'delete';

        public function render($request , $data , $model  , $view, $field = null)
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

        public function Authorization($authorization,$data)
        {
            return $authorization->authorizeToDelete($data);
        }


    }