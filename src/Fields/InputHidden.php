<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;

    class InputHidden extends Field
    {
        use Resource;

        public $nameViewForm = 'InputHidden';

        public function __construct(string $name = null){

            $this->name=$name;

            $this->onlyOnForms();
        }

    }