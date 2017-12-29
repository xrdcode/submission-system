<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 2:46
 */

Route::group(
    [
        'prefix' => 'module/manage',
        'as' => 'module.manage',
        'namespace' => 'App\Modules\ModuleManagement\Controllers',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::get('/newmodule', ['as' => '.newmodule', 'uses' => 'EditController@newmodule', 'middleware' => []]);;
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);;
    Route::get('/activate/{id}', ['as' => '.activate', 'uses' => 'EditController@activate', 'middleware' => []]);;

    Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);
});