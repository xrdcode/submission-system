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
    Route::post('/delete/{id}', ['as' => '.delete', 'uses' => 'EditController@delete', 'middleware' => []]);;
    Route::get('/activate/{id}', ['as' => '.activate', 'uses' => 'EditController@activate', 'middleware' => []]);;

    //Route::get('/detail/{id}', ['as' => '.detail', 'uses' => 'DetailController@index', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DTPricing', 'middleware' => []]);


    Route::get('/type', ['as' => '.type','uses' => 'ListController@type', 'middleware' => []]);
    Route::get('/type/new', ['as' => '.type.new', 'uses' => 'EditController@new_type', 'middleware' => []]);;
    Route::post('/type/store', ['as' => '.type.store', 'uses' => 'EditController@store_type', 'middleware' => []]);;
    Route::post('/type/delete/{id}', ['as' => '.type.delete', 'uses' => 'EditController@delete_type', 'middleware' => []]);;
    Route::get('/type/dt', ['as' => '.type.dt', 'uses' => 'ListController@DTPtype', 'middleware' => []]);
    Route::get('/type/edit/{id}', ['as' => '.type.edit', 'uses' => 'EditController@edit_type', 'middleware' => []]);
    Route::post('/type/edit/{id}', ['as' => '.type.update', 'uses' => 'EditController@update_type', 'middleware' => []]);


});


Route::group(
    [
        'prefix' => 'admin/submission',
        'as' => 'admin.submission',
        'namespace' => 'App\Modules\SubmissionManagement\Controllers\Submission',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);


    Route::get('/paymentinfo/{id}', ['as' => '.paymentinfo', 'uses' => 'ListController@paymentinfo', 'middleware' => []]);

    Route::post('/setprogress/{id}', ['as' => '.progress', 'uses' => 'EditController@setprogress', 'middleware' => []]);
    Route::post('/setapproved/{id}', ['as' => '.approve', 'uses' => 'EditController@setapproved', 'middleware' => []]);

    /// DATATABLE LIST ///
    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);

    /// DOWNLOAD FILE ///
    Route::get('/getabstract/{id}', ['as' => '.getabstract', 'uses' => 'ListController@getAbstractFile', 'middleware' => []]);
    Route::get('/getpaper/{id}', ['as' => '.getpaper', 'uses' => 'ListController@getpaper', 'middleware' => []]);


    //// MODAL ////
    Route::get('/edit/{id}', ['as' => '.edit', 'uses' => 'EditController@index', 'middleware' => []]);
    Route::post('/edit/{id}', ['as' => '.update', 'uses' => 'EditController@update', 'middleware' => []]);

    Route::get('/payment/{id}', ['as' => '.payment', 'uses' => 'EditController@_ModalAssignPayment', 'middleware' => []]);;
    Route::post('/setpayment/{id}', ['as' => '.setpayment', 'uses' => 'EditController@setpayment', 'middleware' => []]);

    Route::post('/setfeedback/{id}', ['as' => '.setfeedback', 'uses' => 'EditController@setfeedback', 'middleware' => []]);

    Route::get('/viewabstract/{id}', ['as' => '.abstract', 'uses' => 'ListController@_ModalViewAbstract', 'middleware' => []]);;
});
