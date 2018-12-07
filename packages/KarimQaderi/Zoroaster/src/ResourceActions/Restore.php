<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Restore extends Button
    {
        public $component = 'show';
        public $hideFromDetail = true;

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

        public function Authorization($authorization , $data)
        {
            if($data->attributesToArray('deleted_at') && $data->deleted_at != null)
                return $authorization->authorizedToRestore($data);
            else
                return false;
        }

    }