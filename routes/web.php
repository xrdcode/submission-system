<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//
//Route::get('/', ['uses' => 'LoginController@showLoginForm','middleware' => ['guest']]);
//Route::prefix('')->namespace('App\Modules\User\Controllers\Auth')->group(function() {
//});

Route::get('/',function() {
    return redirect()->route('user');
});

Route::get('/test/abstractnotif/{id}', ['uses' => 'DebugController@testAbstractNotification']);
