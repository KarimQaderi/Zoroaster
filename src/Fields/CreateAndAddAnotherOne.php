<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Extend\Field;

    class CreateAndAddAnotherOne extends Field
    {

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
