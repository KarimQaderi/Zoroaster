<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Delete extends ShowOrHiden
    {

        public $component = 'delete';

        public $showFromDetail = true;
        public $showFromIndex = true;

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

        public function Authorization($request , $data)
        {
            if(array_key_exists('deleted_at' , $data->attributesToArray())){
                if($data->deleted_at !== null)
                    return false;
                else
                    return $request->Resource()->authorizedToDelete($data);
            } else
                return $request->Resource()->authorizedToForceDelete($data);

        }


    }