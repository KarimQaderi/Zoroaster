<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    trait TraitView
    {


        public function render($builder , $field = null, $ResourceRequest = null)
        {
            return view('Zoroaster::fields.' . $builder->nameViewForm)->with(
                [
                    'builder' => $builder ,
                    'field' => $field ,
                    'newResource' => $ResourceRequest ,
                ]);
        }

    }