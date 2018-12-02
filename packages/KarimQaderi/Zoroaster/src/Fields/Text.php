<?php

    namespace KarimQaderi\Zoroaster\Fields;



    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class Text extends Field
    {

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'text';

        /**
         * Display the field as raw HTML using Vue.
         *
         * @return $this
         */
        public function asHtml()
        {
            return $this->withMeta(['asHtml' => true]);
        }

    }