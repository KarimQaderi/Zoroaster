<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Restore extends ShowOrHiden
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

        public function Authorization($request , $data)
        {
            if(method_exists($request->newModel() , 'isForceDeleting') && $data->deleted_at != null)
                return $request->Resource()->authorizedToRestore($data);
            else
                return false;
        }

    }