<?php

    namespace KarimQaderi\Zoroaster\Fields;


    use KarimQaderi\Zoroaster\Fields\Other\Field;

    class ID extends Field
    {
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

        /**
         * Create a new, resolved ID field for the givne model.
         *
         * @param  \Illuminate\Database\Eloquent\Model $model
         * @return static
         */
        public static function forModel($model)
        {
            return tap(static::make('ID' , $model->getKeyName()))->resolve($model);
        }
    }
