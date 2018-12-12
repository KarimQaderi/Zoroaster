<?php

    namespace KarimQaderi\Zoroaster\Fields\Other;


    use Illuminate\Support\Str;
    use Illuminate\Support\Traits\Macroable;
    use JsonSerializable;
    use KarimQaderi\Zoroaster\Contracts\Resolvable;
    use KarimQaderi\Zoroaster\Fields\Traits\ResourceDefault;
    use KarimQaderi\Zoroaster\Fields\Traits\View;

    abstract class Field extends FieldElement implements JsonSerializable
    {
        use Macroable , View , ResourceDefault;

        /**
         * The displayable name of the field.
         *
         * @var string
         */
        public $label;

        /**
         * The name / column name of the field.
         *
         * @var string
         */
        public $name;

        /**
         * The field's resolved value.
         *
         * @var mixed
         */
        public $value;


        /**
         * The validation rules for creation and updates.
         *
         * @var array
         */
        public $rules = [];

        /**
         * The validation rules for creation.
         *
         * @var array
         */
        public $creationRules = [];

        /**
         * The validation rules for updates.
         *
         * @var array
         */
        public $updateRules = [];

        /**
         * Indicates if the field should be sortable.
         *
         * @var bool
         */
        public $sortable = false;

        /**
         * The text alignment for the field's text in tables.
         *
         * @var string
         */
        public $textAlign = 'right';

        /**
         * The custom components registered for fields.
         *
         * @var array
         */
        public static $customComponents = [];

        /**
         * Create a new field.
         *
         * @param  string $label
         * @param  string|null $name
         * @param  mixed|null $resolveCallback
         * @return void
         */
        public function __construct($label , $name = null)
        {
            $this->label = $label;
            $this->name = $name ?? str_replace(' ' , '_' , Str::lower($label));
        }

        /**
         * Set the help text for the field.
         *
         * @param  string $helpText
         * @return $this
         */
        public function help($helpText)
        {
            return $this->withMeta(['helpText' => $helpText]);
        }


        /**
         * Set the validation rules for the field.
         *
         * @param  callable|array|string $rules
         * @return $this
         */
        public function rules($rules)
        {
            $this->rules = is_string($rules) ? func_get_args() : $rules;

            return $this;
        }


        /**
         * Specify that this field should be sortable.
         *
         * @param  bool $value
         * @return $this
         */
        public function sortable($value = true)
        {
            if(!$this->computed()){
                $this->sortable = $value;
            }

            return $this;
        }

        /**
         * Determine if the field is computed.
         *
         * @return bool
         */
        public function computed()
        {
            return is_callable($this->name) ||
                $this->name == 'ComputedField';
        }

        /**
         * Get the component label for the field.
         *
         * @return string
         */
        public function component()
        {
            if(isset(static::$customComponents[get_class($this)])){
                return static::$customComponents[get_class($this)];
            }

            return $this->component;
        }

        /**
         * Set the component that should be used by the field.
         *
         * @param  string $component
         * @return void
         */
        public static function useComponent($component)
        {
            static::$customComponents[get_called_class()] = $component;
        }

        /**
         * Prepare the field for JSON serialization.
         *
         * @return array
         */
        public function jsonSerialize()
        {
            return array_merge([
                'component' => $this->component() ,
                'prefixComponent' => true ,
                'indexName' => $this->label ,
                'label' => $this->label ,
                'name' => $this->name ,
                'value' => $this->value ,
                'panel' => $this->panel ,
                'sortable' => $this->sortable ,
                'textAlign' => $this->textAlign ,
            ] , $this->meta());
        }


    }
