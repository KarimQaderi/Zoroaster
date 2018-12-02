<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    use Illuminate\Http\Resources\MergeValue;
    use JsonSerializable;

    class Panel extends MergeValue implements JsonSerializable
    {
        /**
         * The name of the panel.
         *
         * @var string
         */
        public $component = 'Panel';

        public $name;

        public $class;

        /**
         * The panel fields.
         *
         * @var array
         */
        public $data;

        /**
         * Create a new panel instance.
         *
         * @param  string $name
         * @param  \Closure|array $fields
         * @return void
         */
        public function __construct($name , $fields = [] , $class = null)
        {
            $this->name = $name;
            $this->class = $class;

            parent::__construct($this->prepareFields($fields));
        }

        /**
         * Prepare the given fields.
         *
         * @param  \Closure|array $fields
         * @return array
         */
        protected function prepareFields($fields)
        {
            return collect(is_callable($fields) ? $fields() : $fields)->each(function($field){
                $field->panel = $this->name;
            })->all();
        }

        /**
         * Get the default panel name for the given resource.
         *
         * @param  \Laravel\Nova\Resource $resource
         * @return string
         */
        public static function defaultNameFor()
        {
//            return $resource->singularLabel().' '.__('Details');
        }

        /**
         * Prepare the panel for JSON serialization.
         *
         * @return array
         */
        public function jsonSerialize()
        {
            return [
                'component' => 'Panel' ,
                'name' => $this->name ,
            ];
        }

        public function viewForm($data , $field)
        {
            return view('Zoroaster::fields.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                ]);
        }

        public function viewDetail($data , $field)
        {
            return view('Zoroaster::fields.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                ]);
        }

        public function viewIndex($data , $field)
        {
            return view('Zoroaster::fields.' . $field->component)->with(
                [
                    'data' => $data ,
                    'field' => $field ,
                ]);
        }
    }