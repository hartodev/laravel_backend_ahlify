<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:user'])->group(function () {

    Route::get('/user/me', function (Request $request) {
        return $request->user();
    });
});

Route::middleware(['auth:sanctum', 'role:partner'])->group(function () {

    Route::get('/partner/me', function (Request $request) {
        return $request->user();
    });
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::get('/admin/me', function (Request $request) {
        return $request->user();
    });
});

Route::middleware(['auth:sanctum', 'role:user,partner'])->group(function () {

    // Route::get('/chat/rooms', [ChatController::class, 'rooms']);
});
