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

Route::post('login', 'App\Http\Controllers\AuthController@login');
Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::get('logout', 'App\Http\Controllers\AuthController@logout');
Route::get('whoami', 'App\Http\Controllers\UserController@getInfo');

/* Booking */
Route::get('booking', 'App\Http\Controllers\BookingController@getList');

/* User */
Route::get('user/{id}/bookings', 'App\Http\Controllers\UserController@getBookingList');


