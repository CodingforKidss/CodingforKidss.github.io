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
/*Route::get('/', function () {
    return view('welcome');
});*/
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{vue_capture?}', function () {
    return view('layouts.app');
})->where('vue_capture', '[\/\w\.-]*');
/*Route::get('/', function () {
    return view('welcome');
});
//Auth::routes();
Route::post('/email-test', 'HomeController@sendEmail')->name('testEmail.post');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/password/reset', 'Auth\ForgotPasswordaController@showLinkRequestForm')->name('password.reset');
Route::post('/password/email', 'Auth\ForgotPasswordaController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.post');
//Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');*/
