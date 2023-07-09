<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\GeneralApiController;
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

/* * * Booking Routes ** */
Route::controller(BookingController::class)->group(function () {
    Route::get('bookings', 'index');
    Route::post('bookings/store', 'store');
    Route::get('bookings/cancel/{booking}', 'cancel');
    Route::get('bookings/{booking}', 'show');
    Route::delete('bookings/{booking}', 'destroy');
    Route::get('getFrequentTripUsers', 'getFrequentTripUser');
});

/* * * Auth Routes ** */
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('user-profile', 'userProfile');
});

/* * * General Routes ** */
Route::controller(GeneralApiController::class)->group(function () {
    Route::get('seats', 'seats');
    Route::get('trips', 'trips');
    Route::get('buses', 'buses');
});



