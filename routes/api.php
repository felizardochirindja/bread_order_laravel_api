<?php

use App\Http\Controllers\V1\DailyOrderController;
use App\Http\Controllers\V1\MonthlyOrderController;
use App\Http\Controllers\V1\PaymentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function() {
    Route::prefix('daily-orders')->group(function() {
        Route::apiResource('', DailyOrderController::class)->except([
            'update'
        ]);
        Route::post('imediate-payment', [DailyOrderController::class, 'storeImmediatePaymentOrder']);
        Route::put('{id}', [DailyOrderController::class, 'update']);
    });

    Route::prefix('monthly-orders')->group(function() {
        Route::get('', [MonthlyOrderController::class, 'index']);
        Route::get('{id}', [MonthlyOrderController::class, 'show']);
        Route::get('{id}/daily-orders', [MonthlyOrderController::class, 'listDailyOrders']);
        Route::get('{id}/payments', [MonthlyOrderController::class, 'listPayments']);
    });

    Route::prefix('payments')->group(function() {
        Route::get('{id}', [PaymentController::class, 'show']);
        Route::get('{id}/daily-orders', [PaymentController::class, 'listDailyOrders']);
    });
});
