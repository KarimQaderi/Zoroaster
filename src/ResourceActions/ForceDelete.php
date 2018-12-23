<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class ForceDelete extends ShowOrHiden
    {

        public $component = 'delete';

        public $showFromDetail = true;

        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.forceDelete')
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
            if(method_exists($request->newModel() , 'isForceDeleting'))
                return $request->Resource()->authorizedToForceDelete($data);
            else
                return false;


        }


    }