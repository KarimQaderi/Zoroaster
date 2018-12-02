<?php

    namespace App\Http\Controllers\back;

    use App\Http\Controllers\Controller;

    class IndexController extends Controller
    {

        function Index()
        {

            return view('back.index')->with([
                'widgets' => \BuilderFields::widgets(
                    [
                        'App\\back\\Widgets\\Cache' ,
                        'App\\back\\Widgets\\Sessions' ,
                    ]
                ) ,
            ]);
        }


    }
