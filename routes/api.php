<?php

use App\Http\Controllers\API\V1\DailyOrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API\V1'], function() {
    Route::apiResource('daily-orders', DailyOrderController::class);
});
