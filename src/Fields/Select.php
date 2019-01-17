<?php

    namespace KarimQaderi\Zoroaster\Fields;

    use KarimQaderi\Zoroaster\Fields\Extend\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;

    class Select extends Field
    {
        use Resource;

        public $nameViewForm = 'select';

        public function options($options)
        {
            return $this->withMeta([
                'options' => collect($options ?? [])->map(function ($label, $value) {
                    return ['label' => $label, 'value' => $value];
                })->values()->all(),
            ]);
        }

        public function activeEelementByClass($optionsKey_and_Class)
        {
            return $this->withMeta([
                'activeEelementByClass' => collect($optionsKey_and_Class ?? [])->map(function ($class, $key) {
                    return ['optionsKey' => $key, 'class' => $class];
                })->values()->all(),
            ]);
        }


    }