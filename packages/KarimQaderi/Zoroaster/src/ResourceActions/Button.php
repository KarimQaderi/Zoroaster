<?php

    namespace KarimQaderi\Zoroaster\ResourceActions;


    class Button
    {

        public $hideFromDetail = false;
        public $hideFromIndex = false;

        public function hideFromIndex()
        {
            $this->hideFromIndex = true;
        }

        public function hideFromDetail()
        {
            $this->hideFromDetail = true;
        }


    }