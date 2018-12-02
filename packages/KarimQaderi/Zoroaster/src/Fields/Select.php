<?php

    namespace KarimQaderi\Zoroaster\Fields;




    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class Select extends Field
    {

        /**
         * The field's component.
         *
         * @var string
         */
        public $component = 'select';


        /**
         * Set the options for the select menu.
         *
         * @param  array  $options
         * @return $this
         */
        public function options($options)
        {
            return $this->withMeta([
                'options' => collect($options ?? [])->map(function ($label, $value) {
                    return ['label' => $label, 'value' => $value];
                })->values()->all(),
            ]);
        }

        /**
         * Display values using their corresponding specified labels.
         *
         * @return $this
         */
        public function displayUsingLabels()
        {
            return $this->displayUsing(function ($value) {
                return collect($this->meta['options'])
                        ->where('value', $value)
                        ->first()['label'] ?? $value;
            });
        }
    }