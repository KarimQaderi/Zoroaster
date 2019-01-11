<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;


    class Date extends Field
    {
        use Resource;


        public $nameViewForm = 'date';

        public $format = 'Y-m-d';


        public function format($format = 'Y-m-d')
        {
            $this->format = $format;

            return $this;
        }


    }