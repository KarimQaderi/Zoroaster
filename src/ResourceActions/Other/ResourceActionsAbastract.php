<?php

    namespace KarimQaderi\Zoroaster\ResourceActions\Other;


    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Traits\ResourceRequest;

    abstract class ResourceActionsAbastract
    {

        public $component = '';

        //    ShowOrHiden
        public $showFromDetail = false;
        public $showFromIndex = false;
        public $showFromIndexTopLeft = false;

        /**
         * @param $request
         * @param $data
         * @param $model
         * @param $view
         * @param null $field
         * @return \Illuminate\View\View
         */
        abstract public function render($request , $data , $model , $view , $field = null);

        /**
         * @param ZoroasterResource ResourceRequest
         * @return bool
         */
        abstract public function Authorization($resource , $data);

    }