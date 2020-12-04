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
Route::get('booking', 'App\Http\Controllers\BookingController@search');
Route::get('booking/{id}', 'App\Http\Controllers\BookingController@get');
Route::post('booking', 'App\Http\Controllers\BookingController@create');
Route::delete('booking/{id}', 'App\Http\Controllers\BookingController@delete');

/* User */
Route::get('user', 'App\Http\Controllers\UserController@getList');
Route::get('user/{id}/bookings', 'App\Http\Controllers\UserController@getBookingList');

/* Workstation */
Route::get('workstation', 'App\Http\Controllers\WorkstationController@getList');

/* Location */
Route::get('location', 'App\Http\Controllers\LocationController@getList');


