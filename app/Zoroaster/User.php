<?php

    namespace App\Zoroaster;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Image;
    use KarimQaderi\Zoroaster\Fields\Select;
    use KarimQaderi\Zoroaster\Fields\Text;


    class User extends ZoroasterResource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public $model = 'App\\User';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public $title = 'name';

        public $labels = 'کاربران';
        public $label = 'کاربر';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public $search = [
            'name' ,
        ];

        /**
         * Get the fields displayed by the resource.
         *
         * @return array
         */
        public function fields()
        {
            return [

                new Row([
                    new Col('uk-width-2-3' , [
                        new Panel('title' , [

                            ID::make()->rules('required')->onlyOnIndex() ,
                            Text::make('نام' , 'name')->rules('required') ,
                            Image::make('عکس کاربر' , 'avatar')->urlUpload('users')->multiImage()->resize([
                                'small' => [
                                    'w' => 200 ,
                                    'h' => 300 ,
                                ] , 'small_2' => [
                                    'w' => 20 ,
                                    'h' => 30 ,
                                ]
                            ]) ,

                            Text::make('ایمیل' , 'email')->rules('required' , 'max:255') ,
                            Text::make('رمز کاربر' , 'password')->rules('required') ,
                        ])
                    ]) ,

                    new Col('uk-width-1-3' , [
                        new Panel('مشخصات' , [
                            Select::make('is_admin' , 'is_admin')->options([
                                '1' => 'Admin' ,
                                '0' => 'User' ,
                            ]) ,
                            Text::make('created_at' , 'created_at') ,
                            btnSave::make() ,
                        ])
                    ])
                ]) ,


            ];
        }

        public function filters()
        {

        }

        public function AddingAdditionalConstraintsForViewIndex($eloquent)
        {
            // TODO: Implement AddingAdditionalConstraintsForViewIndex() method.
        }
    }
