<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
});

Route::middleware(['auth:sanctum', 'role:partner'])->group(function () {

    // Route::get('/partner/bookings', [BookingController::class, 'index']);
});


Route::middleware(['auth:sanctum', 'role:partner'])->group(function () {

    // Route::get('/partner/bookings', [BookingController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {

    // Route::get('/user/bookings', [BookingController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role:user,partner'])->group(function () {

    // Route::get('/chat/rooms', [ChatController::class, 'rooms']);
});
