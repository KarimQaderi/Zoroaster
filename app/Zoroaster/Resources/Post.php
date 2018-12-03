<?php

    namespace App\Zoroaster\Resources;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\boolean;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\Group\RowOneCol;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Image;
    use KarimQaderi\Zoroaster\Fields\Relations\BelongsTo;
    use KarimQaderi\Zoroaster\Fields\Text;
    use KarimQaderi\Zoroaster\Fields\Textarea;
    use KarimQaderi\Zoroaster\Fields\Trix;

    class Post extends ZoroasterResource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public $model = 'App\\Models\\Post';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public $title = 'title';

        public $labels = 'پست ها';
        public $label = 'پست';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public $search = [
            'id' ,
            'title' ,
            'slug' ,
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

                            new RowOneCol([
                                ID::make()->rules('required')->hideWhenCreating() ,
                            ]) ,

                            new Row([
                                new Col('uk-width-1-2' , [
                                    Text::make('عنوان پست' , 'title')
                                        ->help('عنوان اصلی پست برای نمایش پست')
                                        ->rules('required') ,
                                ]) ,

                                new Col('uk-width-1-2' , [
                                    Text::make('slug' , 'slug')->rules('required') ,
                                ]) ,

                            ]) ,

                            new RowOneCol([
                                Trix::make('متن پست' , 'body')->hideFromIndex()->rules('required') ,
                            ]) ,

//                            new RowOneCol([
//                                Image::make('عکس پست' , 'img')->urlUpload('posts')->resize([
//                                    'small' => [
//                                        'w' => 200 ,
//                                        'h' => 300 ,
//                                    ] , 'small_2' => [
//                                        'w' => 20 ,
//                                        'h' => 30 ,
//                                    ]
//                                ])->onlyOnForms() ,
//                            ]) ,

//                            new RowOneCol([
//                                Image::make('گالری' , 'img_multi')
//                                    ->disk('public')
//                                    ->urlUpload('posts')->multiImage(5)->resize([
//                                    'small' => [
//                                        'w' => 200 ,
//                                        'h' => 300 ,
//                                    ] , 'small_2' => [
//                                        'w' => 20 ,
//                                        'h' => 30 ,
//                                    ]
//                                ])->onlyOnForms() ,
//                            ]) ,


                        ]) ,

                    ]) ,


                    new Col('uk-width-1-3' , [
                        new Panel('مشخصات' , [

                            new Row([
                                new Col('uk-width-1-2' , [
                                    boolean::make('نمایش پست' , 'is_published') ,
                                ]) ,
                                new Col('uk-width-1-2' , [
                                    boolean::make('پست ثابت' , 'featured') ,
                                ]) ,

                            ]) ,

                            new RowOneCol([
                                BelongsTo::make('نام کاربر' , 'user_id' , 'App\User')
                                    ->displayTitleField('name')
                                    ->routeShow('Zoroaster.resource.show') ,
                            ]) ,

                            new RowOneCol([
                                Text::make('created_at' , 'created_at') ,
                            ]) ,

                            btnSave::make() ,

                        ]) ,
                    ]) ,
                ]) ,


            ];
        }


        /**
         * Get the filters available for the resource.
         *
         * @return array
         */
        public function filters()
        {
            return [

            ];
        }

        public function AddingAdditionalConstraintsForViewIndex($eloquent)
        {
            return $eloquent->orderByDesc('updated_at');
        }

     

    }
