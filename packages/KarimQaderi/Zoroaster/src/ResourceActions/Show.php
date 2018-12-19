<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Show extends ShowOrHiden
    {
        public $component = 'show';

        public $showFromIndex = true;

        public function render($request , $data , $model , $view , $field = null)
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

        public function Authorization($request , $data)
        {
            return $request->Resource()->authorizedToShow($data);
        }

    }