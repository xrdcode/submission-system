<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 30/12/2017
 * Time: 13:57
 */

Route::group(
    [
        'prefix' => 'admin/event',
        'as' => 'admin.event',
        'namespace' => 'App\Modules\SubmissionManagement\Controllers\Events',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newevent', 'middleware' => []]);;
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);;
    Route::get('/activate/{id}', ['as' => '.activate', 'uses' => 'EditController@activate', 'middleware' => []]);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DTEvents', 'middleware' => []]);
});

Route::group(
    [
        'prefix' => 'admin/submission',
        'as' => 'admin.submission',
        'namespace' => 'App\Modules\SubmissionManagement\Controllers\Submission',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DTEvents', 'middleware' => []]);
});

Route::group(
    [
        'prefix' => 'admin/pricing',
        'as' => 'admin.pricing',
        'namespace' => 'App\Modules\SubmissionManagement\Controllers\Pricing',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newprice', 'middleware' => []]);;
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);;
    Route::get('/activate/{id}', ['as' => '.activate', 'uses' => 'EditController@activate', 'middleware' => []]);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DTPricing', 'middleware' => []]);
});


Route::group(
    [
        'prefix' => 'admin/submission',
        'as' => 'admin.submission',
        'namespace' => 'App\Modules\SubmissionManagement\Controllers\Submission',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/getabstract/{id}', ['as' => '.getabstract', 'uses' => 'ListController@getabstract', 'middleware' => []]);
    Route::get('/getpaper/{id}', ['as' => '.getpaper', 'uses' => 'ListController@getpaper', 'middleware' => []]);
    Route::get('/paymentinfo/{id}', ['as' => '.paymentinfo', 'uses' => 'ListController@paymentinfo', 'middleware' => []]);

    Route::get('/attachpaymment/{id}', ['as' => '.attachpayment', 'uses' => 'ListController@attachpayment', 'middleware' => []]);

    Route::post('/setprogress/{id}', ['as' => '.progress', 'uses' => 'EditController@setprogress', 'middleware' => []]);
    Route::post('/setapproved/{id}', ['as' => '.approve', 'uses' => 'EditController@setapproved', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);;

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);
});