<?php

    namespace App\Zoroaster\Resources;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\CreateAndAddAnotherOne;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Number;
    use KarimQaderi\Zoroaster\Fields\Text;


    class Categorie extends ZoroasterResource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public static $model = 'App\\Models\\Categorie';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public $title = 'title';

        public $labels = 'دسته بندی ها';
        public $label = 'دسته بندی';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public $search = [
            'id' ,'title'
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
                            Text::make('عنوان' , 'title')->rules('required') ,
                            btnSave::make(),
                            CreateAndAddAnotherOne::make(),

                        ])
                    ]) ,

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
