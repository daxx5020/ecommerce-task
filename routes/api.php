<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\UserManagementController;
use App\Http\Controllers\Api\Admin\ProductController;
use App\Http\Controllers\Api\User\ProductBrowseController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\User\OrderController as UserOrderController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\User\UserController;


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
        Route::get('/products', [ProductBrowseController::class, 'index']);
        Route::post('/orders', [UserOrderController::class, 'store']);
        Route::get('/my-orders', [UserOrderController::class, 'index']);
        Route::put('/profile', [UserController::class, 'update']);


    });

    /**
     * Admin APIs
     */
    Route::middleware('role:super-admin')->prefix('admin')->group(function () {
        Route::get('/users', [UserManagementController::class, 'index']);
        Route::get('/users/{id}', [UserManagementController::class, 'show']);
        Route::patch('/users/{id}/status', [UserManagementController::class, 'updateStatus']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::patch('/products/{id}', [ProductController::class, 'update']);
        Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::post('/notifications', [NotificationController::class, 'store']);
        Route::get('/reports/top-users', [ReportController::class, 'topUsers']);
        Route::get('/products/{id}/logs', [ProductController::class, 'logs']);

    });
});
