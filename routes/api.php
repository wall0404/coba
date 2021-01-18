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
Route::post('signup', 'App\Http\Controllers\AuthController@signup');
Route::get('logout', 'App\Http\Controllers\AuthController@logout');
Route::get('whoami', 'App\Http\Controllers\UserController@getInfo');

Route::middleware('auth')->group(function () {
    Route::post('resetPassword', 'App\Http\Controllers\AuthController@resetPassword');

    /* Booking */
    Route::get('booking', 'App\Http\Controllers\BookingController@search');
    Route::get('booking/{id}', 'App\Http\Controllers\BookingController@get');
    Route::post('booking', 'App\Http\Controllers\BookingController@create');
    Route::delete('booking/{id}', 'App\Http\Controllers\BookingController@delete');

    /* User */
    Route::get('user', 'App\Http\Controllers\UserController@getList');
    Route::get('user/{id}/bookings', 'App\Http\Controllers\UserController@getBookingList');
    Route::get('my_favorites', 'App\Http\Controllers\UserController@myFavorites');

    /* Workstation */
    Route::get('workstation', 'App\Http\Controllers\WorkstationController@getList');

    /* FavoriteSeats */
    Route::post('workstation/favorite', 'App\Http\Controllers\FavoriteSeatController@addFavoriteSeat');
    Route::delete('workstation/favorite', 'App\Http\Controllers\FavoriteSeatController@removeFavoriteSeat');
    Route::post('getInfo' , 'App\Http\Controllers\FavoriteSeatController@getInfo') ;

    /* Avatar */
    Route::prefix('/profile_picture')->group(function () {
        Route::get('/{id}', 'App\Http\Controllers\ProfilePictureController@getPic');
        Route::post('/{id}', 'App\Http\Controllers\ProfilePictureController@uploadPic');
        Route::delete('/{id}', 'App\Http\Controllers\ProfilePictureController@deletePic');
    });

});


/* Location */
Route::get('location', 'App\Http\Controllers\LocationController@getList');
