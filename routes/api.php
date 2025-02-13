<?php

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\DailyOrderController;
use App\Http\Controllers\V1\MonthlyOrderController;
use App\Http\Controllers\V1\PaymentController;
use App\Http\Controllers\V1\UserController;
use App\Http\Middleware\V1\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function () {
    Route::prefix('daily-orders')->middleware(AuthMiddleware::class)->group(function () {
        Route::post('', [DailyOrderController::class, 'store']);
        Route::post('imediate-payment', [DailyOrderController::class, 'storeImmediatePayment']);

        Route::prefix('{id}')->group(function() {
            Route::put('', [DailyOrderController::class, 'update']);
            Route::get('', [DailyOrderController::class, 'show']);
        });
    });

    Route::prefix('monthly-orders')->middleware(AuthMiddleware::class)->group(function () {
        Route::get('', [MonthlyOrderController::class, 'index']);

        Route::prefix('{id}')->group(function() {
            Route::get('', [MonthlyOrderController::class, 'show']);
            Route::get('daily-orders', [MonthlyOrderController::class, 'listDailyOrders']);
            Route::get('payments', [MonthlyOrderController::class, 'listPayments']);
        });
    });

    Route::prefix('payments')->middleware(AuthMiddleware::class)->group(function () {
        Route::post('periodic', [PaymentController::class, 'storePeriodicPayment']);
        
        Route::prefix('{id}')->group(function() {
            Route::get('', [PaymentController::class, 'show']);
            Route::get('daily-orders', [PaymentController::class, 'listDailyOrders']);
        });
    });

    Route::prefix('users')->middleware(AuthMiddleware::class)->group(function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('{id}', [UserController::class, 'show']);
        Route::put('update', [UserController::class, 'update']);
    });

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('sign-up', [AuthController::class, 'signUp']);
        Route::get('logout', [AuthController::class, 'logout'])->middleware(AuthMiddleware::class);
        Route::get('refresh', [AuthController::class, 'refresh'])->middleware(AuthMiddleware::class);
        Route::get('me', [AuthController::class, 'me'])->middleware(AuthMiddleware::class);
    });
});
