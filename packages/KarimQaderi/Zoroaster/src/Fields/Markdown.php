<?php

    namespace KarimQaderi\Zoroaster\Fields;



    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;


    class Markdown extends Field
    {
        use Resource;


        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'markdown';





    }