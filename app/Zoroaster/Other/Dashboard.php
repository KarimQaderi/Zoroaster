<?php

    namespace App\Zoroaster\Other;


    use App\back\Widgets\Cache;
    use App\back\Widgets\Sessions;
    use App\Zoroaster\Metrics\PostCount;
    use App\Zoroaster\Metrics\PostCountOverTime;
    use App\Zoroaster\Metrics\PostCountOverTimeResults;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Row;

    class Dashboard
    {

        static function handle()
        {
            return [


                new Row([

                    new Col('uk-width-1-3' , [
                        new PostCountOverTime() ,
                    ]) ,

                    new Col('uk-width-1-3' , [
                        new PostCountOverTimeResults() ,
                    ]) ,

                    new Col('uk-width-1-3' , [
                        new PostCount() ,
                    ]) ,

                ]) ,




            ];
        }
    }