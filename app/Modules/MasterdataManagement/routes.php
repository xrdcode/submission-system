<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 2:46
 */

Route::group(
    [
        'prefix' => 'admin/master/workstate',
        'as' => 'admin.master.workstate',
        'namespace' => 'App\Modules\MasterdataManagement\Controllers\Workstate',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index']);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search']);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index']);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update']);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newws']);;
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store']);;
    Route::get('/activate/{id}', ['as' => '.activate', 'uses' => 'EditController@activate']);;
    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DTWorkstate']);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index']);
});

Route::group(
    [
        'prefix' => 'admin/master/room',
        'as' => 'admin.master.room',
        'namespace' => 'App\Modules\MasterdataManagement\Controllers\Room',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index']);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index']);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update']);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newroom']);;
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store']);;
    Route::post('/delete/{id}', ['as' => '.delete', 'uses' => 'EditController@delete']);;
    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT']);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index']);
});