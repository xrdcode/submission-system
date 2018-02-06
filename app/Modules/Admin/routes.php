<?php
/*
|--------------------------------------------------------------------------
| Admin Module Routes
|--------------------------------------------------------------------------
|
| All the routes related to the Admin module have to go in here. Make sure
| to change the namespace in case you decide to change the
| namespace/structure of controllers.
|
*/
Route::group(['prefix' => 'admin','as' => 'admin', 'namespace' => 'App\Modules\Admin\Controllers'], function () {
    Route::get('/', ['uses' => 'DashboardController@index', 'middleware' => ['web','auth:admin']]);
    Route::get('dashboard', ['as' => '.dashboard', 'uses' => 'DashboardController@index', 'middleware' => ['web','auth:admin']]);

    //SITE SETTING ROUTE
    Route::get('sitesetting', ['as' => '.settings', 'uses' => 'SiteSettingController@index', 'middleware' => ['web','auth:admin']]);
    Route::post('setting/update', ['as' => '.settings.update', 'uses' => 'SiteSettingController@update', 'middleware' => ['web','auth:admin']]);


});

Route::group(['middleware' => ['web'], 'prefix' => 'admin', 'as' => 'admin', 'namespace' => 'App\Modules\Admin\Controllers\Auth'], function () {
    Route::get('/login', ['as' => '.login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('/login', ['as' => '.loging', 'uses' => 'LoginController@login']);
    Route::post('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout']);
});