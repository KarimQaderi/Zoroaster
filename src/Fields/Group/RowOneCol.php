<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    use Illuminate\Http\Resources\MergeValue;
    use JsonSerializable;

    class RowOneCol extends MergeValue implements JsonSerializable
    {

        use TraitView;

        /**
         * عنصر نام
         *
         * @var string
         */
        public $component = 'field_group';

        /**
         * view نام
         *
         * @var string
         */
        public $nameViewForm = 'RowOneCol';

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        /**
         * ایجاد
         *
         * @param  \Closure|array $fields
         * @return void
         */
        public function __construct($fields = [])
        {
            parent::__construct($this->prepareFields($fields));
        }

        /**
         * ها عنصر سازی اماده
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
         * کند می اماده JSON serialization برای را عنصر
         *
         * @return array
         */
        public function jsonSerialize()
        {
            return [
                'component' => $this->component  ,
            ];
        }

    }