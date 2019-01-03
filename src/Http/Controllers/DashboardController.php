<?php

    namespace KarimQaderi\Zoroaster\Http\Controllers;

    use App\Http\Controllers\Controller;

    class DashboardController extends Controller
    {
        public function handle()
        {

            return view('Zoroaster::index')->with([
                'widgets' => \Zoroaster::Widgets(
                    [
                        'App\\back\\Widgets\\Cache' ,
                        'App\\back\\Widgets\\Sessions' ,
                    ]
                ) ,
            ]);
        }


        protected function Query($request)
        {

        }

    }