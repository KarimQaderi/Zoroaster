<?php

    namespace App\Zoroaster\Other;


    use App\back\Widgets\Cache;
    use App\back\Widgets\Sessions;
    use KarimQaderi\Zoroaster\Fields\Group\Col;
    use KarimQaderi\Zoroaster\Fields\Group\Row;

    class Dashboard
    {
        static function handle()
        {
            return [


                new Row([

                    new Col('uk-width-1-2' , [
                        new Cache() ,
                    ]) ,

                    new Col('uk-width-1-2' , [
                        new Sessions() ,
                    ]) ,

                ]) ,


            ];
        }
    }