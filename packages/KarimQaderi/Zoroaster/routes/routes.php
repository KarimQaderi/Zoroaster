<?php

    use Illuminate\Support\Facades\Route;
    use KarimQaderi\Zoroaster\Zoroaster;

//    Markdown::convertToHtml($value);
    Route::group(Zoroaster::routeConfiguration() , function(){

        Route::get('/' , 'DashboardController@handle')->name('home');
        Route::get('/Settings/icons' , 'SettingsIconsController@handle')->name('settings.icons');

        Route::group(['prefix' => 'resource' , 'as' => 'resource.' , 'namespace' => Zoroaster::routeConfiguration()['namespace'] . '\Resource'] , function(){
            Route::get('/{resource}' , 'ResourceIndexController@handle')->name('index');
            Route::get('/{resource}/create' , 'ResourceCreateController@handle')->name('create');
            Route::get('/{resource}/{resourceId}/show' , 'ResourceShowController@handle')->name('show');
            Route::get('/{resource}/{resourceId}/edit' , 'ResourceEditController@handle')->name('edit');
            Route::put('/{resource}/{resourceId}/update' , 'ResourceUpdateController@handle')->name('update');
            Route::post('/{resource}/store' , 'ResourceStoreController@handle')->name('store');
            Route::delete('/{resource}' , 'ResourceDestroyController@handle')->name('destroy');
            Route::put('/{resource}/restore' , 'ResourceRestoreController@handle')->name('restore');


        });

        Route::post('/AjaxFieldController' , 'AjaxFieldController@handle')->name('Ajax.field');
        Route::get('/Field/{controller}/{field}' , 'AjaxFieldController@handle')->name('controller.field');
//        Route::post('/UploadFile/Delete' , 'UploadFileControllers@delete')->name('DeleteFile');

    });
