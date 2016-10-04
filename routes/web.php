<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'wechat.oauth'], function () {

    Route::get('/token', 'JwtController@sentToken');

});

Route::get('/check', 'JwtController@checkToken');

//Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'test'], function () {
    Route::get('token', 'JwtController@testSentToken');
    Route::get('check', 'JwtController@checkToken');
    // Get user info.
    Route::get('/user-info', 'JwtController@userInfo')->middleware('wechat.oauth');
});
