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

Route::get('/user', function (Request $request) {
//    return $request->user();
    return array_map('trim', explode(',', env('WECHAT_OAUTH_SCOPES', 'snsapi_userinfo')));
})->middleware('api');

Route::group(['middleware' => 'jwt_auth'], function () {
    Route::get('test', function () {
        return 'papapa';
    });

//    Route::get('song', 'SongController@index');
//    Route::get('song/{name}', 'SongController@show');
    Route::resource('song', 'API\SongController');
});