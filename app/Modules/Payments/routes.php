<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 10/01/2018
 * Time: 18:34
 */

Route::group(
    [
        'prefix' => 'admin/payment',
        'as' => 'admin.payment',
        'namespace' => 'App\Modules\Payments\Controllers',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/receipt/{id}', ['as' => '.receipt','uses' => 'ListController@viewreceipt', 'middleware' => []]);
//    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);
//
//    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
//    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);
//
//    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newevent', 'middleware' => []]);;
//    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);;
    Route::get('/verify/{id}', ['as' => '.verify', 'uses' => 'EditController@verify', 'middleware' => []]);;
    Route::post('/verify/{id}', ['as' => '.verify', 'uses' => 'EditController@setverified', 'middleware' => []]);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);
});