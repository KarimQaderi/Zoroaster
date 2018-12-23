<?php

    namespace KarimQaderi\Zoroaster\Fields\Traits;


    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    trait ResourceDefault
    {
        public function ResourceDestroy(RequestField $requestField)
        {
            return [
                'error' => [] ,
            ];
        }

        public function beforeResourceStore(RequestField $requestField)
        {
            return [
                'error' => [] ,
                'data' => [] ,
            ];
        }

        public function ResourceStore(RequestField $requestField)
        {
            return [
                'error' => [] ,
                'data' => [] ,
            ];

        }


        public function ResourceUpdate(RequestField $requestField)
        {
            return [
                'error' => [] ,
                'data' => [] ,
            ];

        }
    }