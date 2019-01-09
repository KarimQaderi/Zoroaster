<?php

    namespace KarimQaderi\Zoroaster\Fields\Group;


    use Illuminate\Http\Resources\MergeValue;
    use JsonSerializable;

    class Panel extends MergeValue implements JsonSerializable
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
        public $nameViewForm = 'panel';

        /**
         * عنصر دادهای
         *
         * @var string
         */
        public $class;

        /**
         * دیتابیس در عنصر فیلد نام
         *
         * @var string
         */
        public $name;

        /**
         * ها عنصر
         *
         * @var array
         */
        public $data;

        /**
         * ایجاد
         *
         * @param  string $name
         * @param  \Closure|array $fields
         * @param  string $class
         * @return void
         */
        public function __construct($name , $fields = [] , $class = null)
        {
            $this->name = $name;
            $this->class = $class;

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
                $field->panel = $this->name;
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
                'component' => $this->component ,
                'name' => $this->name ,
            ];
        }

    }