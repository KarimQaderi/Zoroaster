<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    trait View
    {
        public function viewForm($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Form.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                ]);
        }

        public function viewDetail($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Detail.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                ]);
        }

        public function viewIndex($data , $field , $newResource = null)
        {
            return view('Zoroaster::fields.Index.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $newResource ,
                ]);
        }
    }