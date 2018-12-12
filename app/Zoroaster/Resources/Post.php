<?php

    namespace App\Zoroaster\Resources;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\boolean;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\CreateAndAddAnotherOne;
    use KarimQaderi\Zoroaster\Fields\DataTime;
    use KarimQaderi\Zoroaster\Fields\Date;
    use KarimQaderi\Zoroaster\Fields\DateTime;
    use KarimQaderi\Zoroaster\Fields\File;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\Group\RowOneCol;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Image;
    use KarimQaderi\Zoroaster\Fields\PivotCheckBox;
    use KarimQaderi\Zoroaster\Fields\Relations\BelongsTo;
    use KarimQaderi\Zoroaster\Fields\Text;
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

//            new reperater("Name" , "NameGroup")->field([
//            Text:make("name1" , "NameGroup[${number}][name1]"),
//              Text:make("name2" , "NameGroup[${number}][name2]"),
//              ]),

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
                                    Text::make('slug' , 'slug')->rules('required')->onlyOnForms() ,
                                ]) ,

                            ]) ,

                            new RowOneCol([
                                Trix::make('متن پست' , 'body')->hideFromIndex()->rules('required') ,
                            ]) ,

                            new RowOneCol([
                                File::make('فایل' , 'file')
                                    ->onlyOnForms()
                                    ->count(5)
                                    ->storeOriginalName(function($file){
                                        return now()->day . '-' . time() . '-' . $file->getClientOriginalName();
                                    })
                                    ->path(function(){
                                        return 'posts' . '/' . now()->year . '/' . now()->month;
                                    }) ,
                            ]) ,

                            new RowOneCol([
                                Image::make('عکس پست' , 'img')
                                    ->onlyOnForms()
                                    ->storeOriginalName(function($file){
                                        return now()->day . '-' . time() . '-' . $file->getClientOriginalName();
                                    })
                                    ->path(function(){
                                        return 'posts' . '/' . now()->year . '/' . now()->month;
                                    }) ,
                            ]) ,

                            new RowOneCol([
                                Image::make('گالری' , 'img_multi')
//                                    ->resize('small' , 20 , 30)
//                                    ->resize('smagll33' , 200 , 300)
                                    ->onlyOnForms()
                                    ->count(2) ,
                            ]) ,


                        ]) ,

                    ]) ,


                    new Col('uk-width-1-3' , [
                        new Panel('مشخصات' , [

                            new Row([
                                new Col('uk-width-1-2' , [
                                    Boolean::make('نمایش پست' , 'is_published') ,
                                ]) ,
                                new Col('uk-width-1-2' , [
                                    Boolean::make('پست ثابت' , 'featured') ,
                                ]) ,

                            ]) ,

                            new RowOneCol([
                                BelongsTo::make('نام کاربر' , 'user_id' , 'App\User')
                                    ->displayTitleField('name')
                                    ->routeShow('Zoroaster.resource.show') ,
                            ]) ,

                            new RowOneCol([
                                DateTime::make('created_at' , 'created_at') ,
                            ]) ,

                        ]) ,

                        new Panel('' , [
                            new RowOneCol([
                                PivotCheckBox::make('دسته بندی' , 'Categorie')
                                    ->show('App\\Models\\Categorie' , 'title','id')
                                    ->pivot('App\\Models\\CategoriePivot','post_id','categorie_id')
                                    ->addWith(['type' => 'post']) ,
                            ]) ,
                        ]) ,


                        new Panel('' , [
                            btnSave::make() ,
                            CreateAndAddAnotherOne::make() ,

                        ]) ,
                    ]) ,
                ]) ,


            ];
        }


        public function AddingAdditionalConstraintsForViewIndex($eloquent)
        {
            return $eloquent->orderByDesc('updated_at');
        }

//        public function authorizeToUpdate($data)
//        {
//            return $data->user_id == auth()->id();
//        }
//
//
//        public function authorizeToDelete($data)
//        {
//            return $data->user_id == auth()->id();
//        }

        function filters()
        {
            return [

            ];
        }
    }
