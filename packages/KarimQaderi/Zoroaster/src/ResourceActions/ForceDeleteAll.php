<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class ForceDeleteAll extends ShowOrHiden
    {

        public $component = 'delete';

        public $showFromIndexTopLeft = true;

        public function render($request , $data , $model , $view , $field = null)
        {
            return view('Zoroaster::resources.actions.forceDeletingAll')
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
            if(method_exists($request->Model() , 'isForceDeleting'))
                return $request->Resource()->authorizedToForceDelete($data);
            else
                return false;

        }


    }