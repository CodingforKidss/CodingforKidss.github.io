<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*Route::group([
    'prefix' => 'v1/'
], function () {
    Route::post('login', 'Api\v1\AppController@login');
    Route::post('register', 'Api\v1\AppController@register');
    Route::post('vsend-fcm', 'Api\v1\AuthAPIController@fcmNotify');
});
Route::group([
    'middleware' => 'auth:api',
    'prefix'     => 'v1/auth'
], function () {
    Route::post('user-profile', 'Api\v1\AppController@userDetails');
    Route::post('update-password', 'Api\v1\AppController@updatePassword');
    Route::post('update-profile', 'Api\v1\AppController@updateProfile');
    Route::post('save-fcm-token', 'Api\v1\AppController@saveFcmToken');
    Route::post('get-requests', 'Api\v1\AppController@getRequests');
});*/
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'prefix' => 'v1/'
], function () {
    Route::post('login', 'Api\v1\WebAppController@login');
    Route::post('register', 'Api\v1\WebAppController@register');
    Route::post('password-forgot', 'Api\v1\WebAppController@passwordForgot');
    Route::post('password-reset', 'Api\v1\WebAppController@passwordReset');
//    Route::post('password-set', 'Api\v1\WebAppController@login'); // not complete
    Route::post('logout', 'Api\v1\WebAppController@logout');

    Route::post('db-form-inputs', 'Api\v1\WebAppController@formInputs');
});
Route::group([
    'middleware' => 'auth:api',
    'prefix'     => 'v1/auth'
], function () {
    Route::post('password-change', 'Api\v1\WebAppController@changePassword');

    Route::post('db-get', 'Api\v1\WebAppController@get');
    Route::post('db-store', 'Api\v1\WebAppController@store');
    Route::patch('db-remove', 'Api\v1\WebAppController@remove');
    Route::patch('db-removes', 'Api\v1\WebAppController@removes');

    Route::post('dashboard-info', 'Api\v1\WebAppController@getDashboard');
    Route::post('report-generator', 'Api\v1\WebAppController@reportGenerator');

    Route::post('upload-file', 'Api\v1\WebAppController@UploadFile');
    Route::post('push-send', 'Api\v1\WebAppController@sendFCMPush');

    /*
    |--------------------------------------------------------------------------
    | Query Routes
    |--------------------------------------------------------------------------
    |
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */
    Route::post('form-inputs-designations', 'Api\v1\QueryController@formInputDesignation');
});


