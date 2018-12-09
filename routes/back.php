<?php


    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Zoroaster;



    Route::group(['middleware' => 'back'] , function(){

        Zoroaster::routes();

        Route::group(['prefix' => 'back' , 'namespace' => 'back' , 'as' => 'back.'] , function(){

//            Route::resource('user' , 'UserController');
//            Route::resource('post' , 'PostController');

        });

    });

