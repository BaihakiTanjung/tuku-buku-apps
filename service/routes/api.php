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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
    Route::get('/user', 'App\Http\Controllers\AuthController@user');
    Route::post('/checkout', 'App\Http\Controllers\PaymentController@create');
    Route::get('/list-user', 'App\Http\Controllers\UserController@index');
    Route::delete('/users/{id}', 'App\Http\Controllers\UserController@destroy');
    Route::get('/payment', 'App\Http\Controllers\PaymentController@index');
    Route::post('/payment/change-status/{id}', 'App\Http\Controllers\PaymentController@changeStatus');
    Route::post('/products', 'App\Http\Controllers\ProductController@store');
    Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@destroy');
});

Route::get('/products', 'App\Http\Controllers\ProductController@index');
