<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class CreateAndAddAnotherOne extends Field
    {
        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'btn';
        public $nameViewForm = 'CreateAndAddAnotherOne';

        public $OnCreation = false;
        public $OnUpdate = false;

        /**
         * Create a new btnSave.
         */
        public function __construct()
        {
            $this->showOnIndex = false;
            $this->showOnDetail = false;
            $this->showOnCreation = true;
            $this->showOnUpdate = false;

        }

    }
