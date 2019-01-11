<?php


    namespace KarimQaderi\Zoroaster\Http\Requests;


    class RequestField
    {
        public $request = null;
        public $resource = null;
        /**
         * @var \KarimQaderi\Zoroaster\Fields\Extend\Field
         */
        public $field = null;
        public $fieldAll = null;
//        public $customAttributes = null;
//        public $validator = null;
        public $MergeResourceFieldsAndRequest = null;
    }