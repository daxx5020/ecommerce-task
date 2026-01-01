<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserManagementController;

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
    Route::middleware('role:super-admin')->prefix('admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index']);
        Route::get('/users/{id}', [UserManagementController::class, 'show']);
        Route::patch('/users/{id}/status', [UserManagementController::class, 'updateStatus']);
    });
});
