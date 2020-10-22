<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/auth/createToken', 'API\Auth\LoginAPIController@createToken');
Route::post('/auth/login', 'API\Auth\LoginAPIController@login')->name('login');
Route::post('/auth/register', 'API\Auth\RegisterAPIController@register');


// Route::get('/auth/user', 'API\Auth\AuthController@user');

// Route::middleware('auth:api')->group(function() {

//     Route::get('user/{userId}/detail', 'API\Auth\AuthController@show');
// });

