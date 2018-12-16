<?php

    namespace App\Zoroaster\Other;


    class Navbar
    {
        static function left()
        {
            return [
                view('Zoroaster::partials.navbar-user') ,
            ];
        }

        static function center()
        {
            return [
                'Zoroaster'
            ];
        }


        static function right()
        {
            return [

            ];
        }
    }