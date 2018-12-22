<?php

    namespace App\Zoroaster\Resources;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\Group\RowOneCol;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Password;
    use KarimQaderi\Zoroaster\Fields\Relations\HasMany;
    use KarimQaderi\Zoroaster\Fields\Select;
    use KarimQaderi\Zoroaster\Fields\Text;


    class User extends ZoroasterResource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = 'App\\User';

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
            'name' , 'id' ,
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
                        new Panel('' , [

                            ID::make()->rules('required')->onlyOnIndex()->sortable() ,
                            Text::make('نام' , 'name')->rules('required') ,
                            Password::make('رمز کاربر' , 'password')->help('برای تغیر نکردن رمز کادر را خالی بزارید') ,
                            Text::make('ایمیل' , 'email')->rules('required' , 'max:255') ,

                        ]) ,
                    ]) ,

                    new Col('uk-width-1-3' , [
                        new Panel('مشخصات' , [
                            Select::make('is_admin' , 'is_admin')->options([
                                '1' => 'Admin' ,
                                '0' => 'User' ,
                            ]) ,
                            Text::make('created_at' , 'created_at') ,
                            btnSave::make() ,
                        ]) ,
                    ]) ,
                ]) ,


                new RowOneCol([
                    HasMany::make('Posts' , 'user_id' , Post::class) ,
                ]) ,


            ];
        }

        public function filters()
        {

        }

    }
