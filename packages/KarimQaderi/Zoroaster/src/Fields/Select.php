<?php

    namespace KarimQaderi\Zoroaster\Fields;




    use KarimQaderi\Zoroaster\Fields\Other\Field;
    use KarimQaderi\Zoroaster\Fields\Traits\Resource;
    use KarimQaderi\Zoroaster\Http\Requests\RequestField;

    class Select extends Field
    {

        use Resource;

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




    }