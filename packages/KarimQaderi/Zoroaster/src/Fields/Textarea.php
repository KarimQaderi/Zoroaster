<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class Textarea extends Field
    {

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'textarea';

        public function rows($rows)
        {
            return $this->withMeta([
                'rows' => $rows,
            ]);
        }
    }