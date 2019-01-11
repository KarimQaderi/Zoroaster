<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Extend\Field;

    class btnSave extends Field
    {

        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'btn';

        /**
         * view نام
         *
         * @var string
         */
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
