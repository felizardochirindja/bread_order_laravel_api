<?php

use App\Http\Controllers\V1\DailyOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\V1'], function() {
    Route::apiResource('daily-orders', DailyOrderController::class)->except([
        'update'
    ]);

    Route::put('daily-orders/{id}', [DailyOrderController::class, 'update']);
});
