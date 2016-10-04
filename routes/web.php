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


// Get user info.
Route::get('/user-info', 'HomeController@userInfo')->middleware('wechat.oauth');

Auth::routes();

Route::get('/home', 'HomeController@index');

// Route::group(['middleware' => 'wechat.oauth'], function () {
    Route::get('/token', 'JwtController@sentToken');
// });
Route::get('/check', 'JwtController@checkToken');

//Route::get('/home', 'HomeController@index');
