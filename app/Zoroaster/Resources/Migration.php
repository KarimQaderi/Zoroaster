<?php

    namespace App\Zoroaster\Resources;

    use KarimQaderi\Zoroaster\Abstracts\ZoroasterResource;
    use KarimQaderi\Zoroaster\Fields\btnSave;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Panel;
    use KarimQaderi\Zoroaster\Fields\Group\Row;
    use KarimQaderi\Zoroaster\Fields\ID;
    use KarimQaderi\Zoroaster\Fields\Image;
    use KarimQaderi\Zoroaster\Fields\Select;
    use KarimQaderi\Zoroaster\Fields\Text;


    class Migration extends ZoroasterResource
    {
        /**
         * The model the resource corresponds to.
         *
         * @var string
         */
        public $model = 'App\\Models\\Migrations';

        /**
         * The single value that should be used to represent the resource when being displayed.
         *
         * @var string
         */
        public $title = 'id';

        public $labels = 'مایگریشن ها';
        public $label = 'مایگریشن';

        /**
         * The columns that should be searched.
         *
         * @var array
         */
        public $search = [
            'id' ,
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
                            Text::make('Migration' , 'migration')->rules('required') ,

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
