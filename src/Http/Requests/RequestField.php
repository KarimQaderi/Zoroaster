<?php


    namespace KarimQaderi\Zoroaster\Http\Requests;


    class RequestField
    {
        public $request = null;
        public $resource = null;

        /** @var \KarimQaderi\Zoroaster\Fields\Extend\Field $field */
        public $field = null;
        public $fieldAll = null;
        public $MergeResourceFieldsAndRequest = null;
    }