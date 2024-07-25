<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DailyOrderController;
use App\Http\Controllers\V1\MonthlyOrderController;
use App\Http\Controllers\V1\PaymentController;
use App\Http\Controllers\V1\UserController;
use App\Http\Middleware\V1\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function () {
    Route::prefix('daily-orders')->group(function () {
        Route::apiResource('', DailyOrderController::class)->except([
            'update'
        ]);
        Route::post('imediate-payment', [DailyOrderController::class, 'storeImmediatePaymentOrder']);
        Route::put('{id}', [DailyOrderController::class, 'update']);
    });

    Route::prefix('monthly-orders')->group(function () {
        Route::get('', [MonthlyOrderController::class, 'index']);
        Route::get('{id}', [MonthlyOrderController::class, 'show']);
        Route::get('{id}/daily-orders', [MonthlyOrderController::class, 'listDailyOrders']);
        Route::get('{id}/payments', [MonthlyOrderController::class, 'listPayments']);
    });

    Route::prefix('payments')->group(function () {
        Route::get('{id}', [PaymentController::class, 'show']);
        Route::get('{id}/daily-orders', [PaymentController::class, 'listDailyOrders']);
    });

    Route::group(['prefix' => 'users', 'middleware' => AuthMiddleware::class], function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('{id}', [UserController::class, 'show']);
        Route::get('create', [UserController::class, 'store']);
        Route::get('update', [UserController::class, 'update']);
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::get('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout'])->middleware(AuthMiddleware::class);
        Route::get('refresh', [AuthController::class, 'refresh'])->middleware(AuthMiddleware::class);
        Route::get('me', [AuthController::class, 'me']);
    });
});
