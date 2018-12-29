<?php


    use KarimQaderi\Zoroaster\Http\Middleware\CheckLogin;

    return [

        /*
        |--------------------------------------------------------------------------
        | Zoroaster App Name
        |--------------------------------------------------------------------------
        */

        'name' => 'Zoroaster' ,


        /*
        |--------------------------------------------------------------------------
        | Zoroaster Resources
        |--------------------------------------------------------------------------
        */

        'Resources' => 'App\\Zoroaster\\Resources\\' ,

        /*
        |--------------------------------------------------------------------------
        | Zoroaster App URL
        |--------------------------------------------------------------------------
        |
        | This URL is where users will be directed when clicking the application
        | name in the Zoroaster navigation bar. You are free to change this URL to
        | any location you wish depending on the needs of your application.
        |
        */

        'url' => env('APP_URL' , '/') ,

        /*
        |--------------------------------------------------------------------------
        | Zoroaster Path
        |--------------------------------------------------------------------------
        |
        | This is the URI path where Zoroaster will be accessible from. Feel free to
        | change this path to anything you like. Note that this URI will not
        | affect Zoroaster's internal API routes which aren't exposed to users.
        |
        */

        'path' => '/back' ,


        /*
        |--------------------------------------------------------------------------
        | Zoroaster Route Middleware
        |--------------------------------------------------------------------------
        |
        | These middleware will be assigned to every Zoroaster route, giving you the
        | chance to add your own middleware to this stack or override any of
        | the existing middleware. Or, you can just stick with this stack.
        |
        */

        'middleware' => [
            'web' ,
            CheckLogin::class

        ] ,

        // Enable Resources permission
        'permission' => false ,

        /*
           |--------------------------------------------------------------------------
           | Path to the Zoroaster Assets
           |--------------------------------------------------------------------------
           |
           | Here you can specify the location of the Zoroaster assets path
           |
           */

        'assets_path' => '/vendor/Zoroaster/assets',

    ];
