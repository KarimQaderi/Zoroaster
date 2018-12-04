<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Edit extends Button
    {
        public $component = 'edit';

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

        public function Authorization($authorization,$data)
        {
            return $authorization->authorizeToUpdate($data);
        }
    }