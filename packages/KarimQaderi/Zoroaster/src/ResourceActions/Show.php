<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Show extends Button
    {
        public $component = 'show';
        public $hideFromDetail = true;

        public function render($request , $data , $model  , $view, $field = null)
        {
            return view('Zoroaster::resources.actions.show')
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
            return $authorization->authorizeToShow($data);
        }

    }