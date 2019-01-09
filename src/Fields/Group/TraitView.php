<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    trait TraitView
    {

        public function render($field , $data , $resourceRequest = null)
        {
            return view('Zoroaster::fields.' . $field->nameViewForm)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                    'newResource' => $resourceRequest ,
                ]);
        }

    }