<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/**
 * Authenticated APIs
 */
Route::middleware('auth:sanctum')->group(function () {

    /**
     * User APIs
     */
    Route::middleware('role:user')->group(function () {
        // user-only routes (orders, profile later)
    });

    /**
     * Admin APIs
     */
    Route::middleware('role:super-admin')->group(function () {
        // admin-only routes (user management, products later)
    });
});
