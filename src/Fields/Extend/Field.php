<?php

    namespace KarimQaderi\Zoroaster\Fields\Extend;


    use Illuminate\Support\Str;
    use Illuminate\Support\Traits\Macroable;
    use JsonSerializable;
    use KarimQaderi\Zoroaster\Fields\Traits\ResourceDefault;
    use KarimQaderi\Zoroaster\Fields\Traits\View;
    use KarimQaderi\ZoroasterMenuBuilder\Http\Models\Menu;
    use KarimQaderi\ZoroasterMenuBuilder\Http\Models\MenuItems;

    abstract class Field extends FieldElement
    {
        use  View , ResourceDefault;

        /**
         * فارسی بصورت عنصر نام
         *
         * @var string
         */
        public $label;

        /**
         * دیتابیس در عنصر فیلد نام
         *
         * @var string
         */
        public $name;

        /**
         * خروجی در مشاهد قابل مقدار
         *
         * @var string
         */
        public $value;


        /**
         * کردن اضافه یا آپدیت برای قوانین
         *
         * @var array
         */
        public $rules = [];


        /**
         * سازی مرتب قابل فیلد
         *
         * @var bool
         */
        public $sortable = false;

        /**
         * جداول در فیلد متن برای متن تراز
         *
         * @var string
         */
        public $textAlign = 'right';

        public $displayCallback;



        /**
         * جدید فیلد ایجاد
         *
         * @param  string $label
         * @param  string|null $name
         * @return void
         */
        public function __construct($label , $name = null)
        {
            $this->label = $label;
            $this->name = $name ?? str_replace(' ' , '_' , Str::lower($label));
        }

        /**
         * Form صفحه در راهنما تنظیم
         *
         * @param  string $helpText
         * @return $this
         */
        public function help($helpText)
        {
            return $this->withMeta(['helpText' => $helpText]);
        }


        /**
         * فیلد برای rules کردن اضافه
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
         * باشد سازی مرتب قابل فیلد اینکه اعمال
         *
         * @param  bool $value
         * @return $this
         */
        public function sortable($value = true)
        {
            $this->sortable = $value;

            return $this;
        }

        public function displayUsing(callable $displayCallback)
        {
            $this->displayCallback = $displayCallback;

            return $this;
        }

    }
