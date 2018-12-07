<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;


    class ID extends Field
    {
        use Resource;

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'text';

        /**
         * Create a new field.
         *
         * @param  string|null $name
         * @param  string|null $attribute
         * @param  mixed|null $resolveCallback
         * @return void
         */
        public function __construct($label = null , $name = null , $resolveCallback = null)
        {
            parent::__construct($label ?? 'ID' , $name , $resolveCallback);
        }




    }
