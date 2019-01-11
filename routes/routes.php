<?php

    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Zoroaster;

    Route::group(Zoroaster::routeConfiguration() , function()
    {

        Route::view('/' , 'Zoroaster::index')->name('dashboard');
        Route::view('/Settings/icons' , 'Zoroaster::Settings.icons')->name('settings.icons');

        Route::group(['prefix' => 'resource/ajax' , 'as' => 'resource-ajax.' , 'namespace' => Zoroaster::routeConfiguration()['namespace'] . '\Resource'] , function()
        {
            Route::get('/' , 'ResourceIndexController@handle')->name('index');
            Route::get('/ResourceIndexRelationship' , 'ResourceIndexRelationshipController@handle')->name('index.relationship');
            Route::post('/SoftDeleting' , 'ResourceSoftDeletingController@handle')->name('softDeleting');
            Route::put('/restore' , 'ResourceRestoreController@handle')->name('restore');
            Route::delete('/' , 'ResourceDestroyController@handle')->name('destroy');
        });

        Route::group(['prefix' => 'resource/{resource}' , 'as' => 'resource.' , 'namespace' => Zoroaster::routeConfiguration()['namespace'] . '\Resource'] , function()
        {
            Route::get('/' , 'ResourceIndexController@handle')->name('index');
            Route::get('/create' , 'ResourceCreateController@handle')->name('create');
            Route::get('/{resourceId}/show' , 'ResourceShowController@handle')->name('show');
            Route::get('/{resourceId}/edit' , 'ResourceEditController@handle')->name('edit');
            Route::put('/{resourceId}/update' , 'ResourceUpdateController@handle')->name('update');
            Route::post('/store' , 'ResourceStoreController@handle')->name('store');
            Route::put('/restore' , 'ResourceRestoreController@handle')->name('restore');
            Route::delete('/' , 'ResourceDestroyController@handle')->name('destroy');
            Route::post('/SoftDeleting' , 'ResourceSoftDeletingController@handle')->name('softDeleting');
        });


        Route::get('/GlobalSearch' , 'Resource\ResourceGlobalSearchController@handle')->name('globalSearch');

        Route::post('/AjaxFieldController' , 'AjaxFieldController@handle')->name('Ajax.field');
        Route::get('/Field/{controller}/{field}' , 'AjaxFieldController@handle')->name('controller.field');

        Route::get('/metrics' , 'MetricController@handle')->name('metrics');

//        Route::post('/UploadFile/Delete' , 'UploadFileControllers@delete')->name('DeleteFile');

    });



    Route::group(Zoroaster::routeConfiguration('middleware') , function()
    {
        Route::get('/login' , 'LoginController@showLoginForm');
        Route::post('/login' , 'LoginController@login')->name('login');
        Route::get('/logout' , 'LoginController@logout')->name('logout');
    });