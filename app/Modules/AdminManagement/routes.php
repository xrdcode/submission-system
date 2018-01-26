<?php

Route::group(
    [
        'prefix' => 'admin/manageadmin',
        'as' => 'admin.manageadmin',
        'namespace' => 'App\Modules\AdminManagement\Controllers',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);
    Route::get('/reset/{id}', ['as' => '.reset', 'uses' => 'EditController@changepass_form', 'middleware' => []]);
    Route::post('/reset/{id}', ['as' => '.reset', 'uses' => 'EditController@change_password', 'middleware' => []]);

    Route::post('/create', ['as' => '.save', 'uses' => 'EditController@store', 'middleware' => []]);

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@addadmin', 'middleware' => []]);;
});

Route::group(
    [
        'prefix' => 'admin/managegroup',
        'as' => 'admin.managegroup',
        'namespace' => 'App\Modules\AdminManagement\Controllers\Group',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newgroup', 'middleware' => []]);;
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);
    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);
});

Route::group(
    [
        'prefix' => 'admin/managerole',
        'as' => 'admin.managerole',
        'namespace' => 'App\Modules\AdminManagement\Controllers\Role',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);
    Route::get('/refresh', ['as' => '.refresh', 'uses' => 'ListController@refreshTable', 'middleware' => []]);
    Route::get('/search', ['as' => '.search', 'uses' => 'ListController@search', 'middleware' => []]);

    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::get('/new', ['as' => '.new', 'uses' => 'EditController@newrole', 'middleware' => []]);
    Route::post('/store', ['as' => '.store', 'uses' => 'EditController@store', 'middleware' => []]);

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);
});