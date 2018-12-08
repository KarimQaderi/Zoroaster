<?php

    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Zoroaster;

//    Markdown::convertToHtml($value);
    Route::group(Zoroaster::routeConfiguration() , function(){

        Route::get('/' , 'DashboardController@handle')->name('home');
        Route::get('/Settings/icons' , 'SettingsIconsController@handle')->name('settings.icons');

        Route::group(['prefix' => 'resource/{resource}' , 'as' => 'resource.' , 'namespace' => Zoroaster::routeConfiguration()['namespace'] . '\Resource'] , function(){
            Route::get('/' , 'ResourceIndexController@handle')->name('index');
            Route::get('/create' , 'ResourceCreateController@handle')->name('create');
            Route::get('/{resourceId}/show' , 'ResourceShowController@handle')->name('show');
            Route::get('/{resourceId}/edit' , 'ResourceEditController@handle')->name('edit');
            Route::put('/{resourceId}/update' , 'ResourceUpdateController@handle')->name('update');
            Route::post('/store' , 'ResourceStoreController@handle')->name('store');
            Route::delete('/' , 'ResourceDestroyController@handle')->name('destroy');
            Route::post('/SoftDeleting' , 'ResourceSoftDeletingController@handle')->name('softDeleting');
            Route::put('/restore' , 'ResourceRestoreController@handle')->name('restore');


        });

        Route::post('/AjaxFieldController' , 'AjaxFieldController@handle')->name('Ajax.field');
        Route::get('/Field/{controller}/{field}' , 'AjaxFieldController@handle')->name('controller.field');
//        Route::post('/UploadFile/Delete' , 'UploadFileControllers@delete')->name('DeleteFile');

    });
