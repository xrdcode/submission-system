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
    Route::get('/receipt/{id}', ['as' => '.receipt','uses' => 'ListController@viewReceipt', 'middleware' => []]);

    //Route::get('/verify/{id}', ['as' => '.verify', 'uses' => 'EditController@verify', 'middleware' => []]);;
    Route::post('/verify/{id}', ['as' => '.verify', 'uses' => 'EditController@setverified', 'middleware' => []]);;

    Route::get('/wsreceipt/{id}', ['as' => '.wsreceipt','uses' => 'ListController@wsViewReceipt', 'middleware' => []]);

    Route::post('/wsverify/{id}', ['as' => '.wsverify', 'uses' => 'EditController@ws_setverified', 'middleware' => []]);;

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);
    Route::get('/dt_ws', ['as' => '.dt_ws', 'uses' => 'ListController@DTWs', 'middleware' => []]);
});

Route::group(
    [
        'prefix' => 'admin/payment/submission',
        'as' => 'admin.payment.submission',
        'namespace' => 'App\Modules\Payments\Controllers\Submission',
        'middleware' => ['web', 'auth:admin']
    ], function () {
    Route::get('/', ['uses' => 'ListController@index', 'middleware' => []]);

    Route::get('/assign/{id}', ['as' => '.assign', 'uses' => 'EditController@_ModalAssignPayment', 'middleware' => []]);;
    Route::post('/setpayment/{id}', ['as' => '.setpayment', 'uses' => 'EditController@setpayment', 'middleware' => []]);

    Route::get('/dt', ['as' => '.dt', 'uses' => 'ListController@DT', 'middleware' => []]);
});