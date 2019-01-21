<?php

    namespace KarimQaderi\Zoroaster;

    use Illuminate\Support\Facades\View;
    use KarimQaderi\Zoroaster\Fields\Extend\Element;

    abstract class Card extends Element
    {

        public $component ='card';

        /**
         * show Card
         *
         * @return view | string
         */
        abstract function render($builder , $resource=null , $ResourceRequest=null);

    }
