<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;


    class Date extends Field
    {
        use Resource;


        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'date';

        public $format = 'Y-m-d';


        public function format($format = 'Y-m-d')
        {
            $this->format = $format;

            return $this;
        }


    }