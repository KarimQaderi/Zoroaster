<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    use Illuminate\Http\Resources\MergeValue;
    use JsonSerializable;

    class RowOneCol extends MergeValue implements JsonSerializable
    {
        /**
         * The name of the panel.
         *
         * @var string
         */


        /**
         * The panel fields.
         *
         * @var array
         */
        public $component = 'RowOneCol';
        public $data;

        /**
         * Create a new panel instance.
         *
         * @param  string $name
         * @param  \Closure|array $fields
         * @return void
         */
        public function __construct($fields = [])
        {

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
            })->all();
        }



        /**
         * Prepare the panel for JSON serialization.
         *
         * @return array
         */
        public function jsonSerialize()
        {
            return [
                'component' => 'RowOneCol' ,
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