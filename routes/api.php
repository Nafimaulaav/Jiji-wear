<?php

use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\PaymentApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::get('/products', [ProductApiController::class, 'index']);
    Route::get('/products/{product}', [ProductApiController::class, 'show']);
    Route::get('/categories', [ProductApiController::class, 'categories']);

    Route::post('/payment/notification', [PaymentApiController::class, 'notification']);

    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/orders', [OrderApiController::class, 'index']);
        Route::get('/orders/{order}', [OrderApiController::class, 'show']);
    });
});