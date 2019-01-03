<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class btnSave extends Field
    {
        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'btn';
        public $nameViewForm = 'btnSave';

        public $OnCreation = false;
        public $OnUpdate = false;

        /**
         * Create a new btnSave.
         */
        public function __construct()
        {
            $this->onlyOnForms();

        }

    }
