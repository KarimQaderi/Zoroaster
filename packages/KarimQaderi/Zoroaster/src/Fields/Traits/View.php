<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    trait View
    {
        public function viewForm($field , $data , $resourceRequest = null)
        {
            try{
                return view('Zoroaster::fields.Form.' . $field->nameViewForm)->with(
                    [
                        'field' => $field ,
                        'data' => $data ,
                        'value' => isset($data->{$field->name})? $data->{$field->name} : null ,
                        'resourceRequest' => $resourceRequest ,
                    ]);
            }catch(\Exception $exception)
            {
                dd($field);
            }
        }

        public function viewDetail($field , $data , $resourceRequest = null)
        {
            return view('Zoroaster::fields.Detail.' . $field->nameViewForm)->with(
                [
                    'field' => $field ,
                    'data' => $data ,
                    'value' => isset($data->{$field->name})? $data->{$field->name} : null ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }

        public function viewIndex($field , $data , $resourceRequest = null)
        {
            return view('Zoroaster::fields.Index.' . $field->nameViewForm)->with(
                [
                    'field' => $field ,
                    'data' => $data ,
                    'value' => isset($data->{$field->name})? $data->{$field->name} : null ,
                    'resourceRequest' => $resourceRequest ,
                ]);
        }
    }