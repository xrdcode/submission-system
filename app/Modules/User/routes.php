<?php
/**
 * Created by PhpStorm.
 * User: muhammad.reyhan
 * Date: 25/10/2017
 * Time: 14:28
 */

// DASHBOARD

Route::prefix('user')->middleware(['web','auth','profile_complete'])->namespace('App\Modules\User\Controllers')->group(function() {
    //USER GET
    Route::get('/', 'DashboardController@index')->name('user');
    Route::get('/dashboard', 'DashboardController@index')->name('user.dashboard');

});

Route::prefix('user')->middleware(['web','auth','profile_complete'])->namespace('App\Modules\User\Controllers')->group(function() {
    //USER GET
    Route::get('/profile', 'ProfileController@index')->name('user.profile');
    Route::post('/update', 'ProfileController@update')->name('user.profile.update');
    Route::get('/security', 'ProfileController@security')->name('user.profile.security');
    Route::post('/security', 'ProfileController@updatepass');

});

Route::group(['prefix' => 'user', 'as' => 'user.submission', 'namespace' => 'App\Modules\User\Controllers\Submission', 'middleware' => ['web','auth','profile_complete']], function() {
    //Submission
    Route::get('/submission', 'MainController@index');
    Route::get('/submission/list', 'MainController@index')->name('.list');
    Route::get('/submission/dt', 'MainController@DTSubmission')->name('.dt');
    Route::get('/submission/register', 'MainController@register')->name('.register');
    Route::post('/submission/submit', 'MainController@submit')->name('.submit');
    Route::post('/submission/edit', 'MainController@reupload')->name('.edit');
    Route::get('/submission/abstract/{id}', 'MainController@getAbstractFile')->name('.getabstract');
    Route::get('/submission/reabstract/{id}', 'MainController@abstractReupload')->name('.abstractreupload');

    //Papers
    Route::get('/submission/{id}/upload', 'PapersController@index')->name('.upload');
    Route::post('/submission/{id}/upload', 'PapersController@upload')->name('.doupload');


});

//LOGIN REGISTER ETC

Route::group(['prefix' => 'user', 'as' => 'user','namespace' => "App\Modules\User\Controllers\Auth", 'middleware' => ['web']], function() {
    Route::get('/login', ['as' => '.login', 'uses' => 'LoginController@showLoginForm', 'middleware' => ['guest']]);
    Route::post('/login', ['as' => '.login', 'uses' => 'LoginController@login', 'middleware' => ['guest']]);

    Route::post('/logout', ['as' => '.logout', 'uses' => 'LoginController@logout', 'middleware' => []]);

    Route::get('/password/reset', ['as' => '.password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm', 'middleware' => ['guest']]);
    Route::get('/password/reset/{token}', ['as' => '.password.reset', 'uses' => 'ResetPasswordController@showResetForm', 'middleware' => ['guest']]);
    Route::post('/password/reset', ['as' => '.password.resets', 'uses' => 'ResetPasswordController@reset', 'middleware' => ['guest']]);

    Route::post('/password/email', ['as' => '.password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail', 'middleware' => ['guest']]);
});

Route::get('/register',['middleware' => ['web'], 'uses' => 'App\Modules\User\Controllers\Auth\RegisterController@showRegistrationForm'])->name('register');
Route::get('/register/done',['middleware' => ['web'], 'uses' => 'App\Modules\User\Controllers\Auth\RegisterController@registerEnd'])->name('register.done');
Route::post('/register',['middleware' => ['web'],'uses' => 'App\Modules\User\Controllers\Auth\RegisterController@register']);

Route::group(['prefix' => "user", 'as' => 'user', 'namespace' => 'App\Modules\User\Controllers\Auth', 'middleware' => ['web','guest']], function() {
    Route::get('/verifyemail/{token}', 'RegisterController@verify')->name('.verifyemail');
    Route::get('/resendverification', 'ResendVerificationController@index')->name('.resendverification');

    Route::post('/sendverification', 'ResendVerificationController@sendVerification')->name('.sendverification');
});

/*Route::group(['prefix' => "oauth", 'as' => 'oauth', 'namespace' => 'App\Modules\User\Controllers\Auth', 'middleware' => ['web','guest']], function() {
    Route::get('/{provider}/callback', 'Social\SocialAuthController@handleProviderCallback')->name('.social.callback');
    Route::post('/{provider}/callback', 'Social\SocialAuthController@handleProviderCallback')->name('.social.callback');
    Route::get('/{provider}', 'Social\SocialAuthController@redirectToProvider')->name('.social.provider');
});*/





// PAYMENT

Route::group(['prefix' => 'user/payment', 'as' => 'user.payment', 'namespace' => 'App\Modules\User\Controllers\Payment', 'middleware' => ['web','auth','profile_complete']], function() {
    //Submission
    Route::get('/', 'PaymentController@index');
    Route::get('/dtwp', 'PaymentController@DTWaitingPayment')->name('.dtwp');
    Route::get('/history', 'PaymentController@history')->name('.history');

    //ID SUBMISSION
    Route::get('/upload/{id}', 'PaymentController@_ModalUploadConfirmation')->name('.upload');
    Route::post('/upload/{id}', 'PaymentController@uploadConfirmation')->name('.save');



});

