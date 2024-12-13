<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController; 

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::apiResource('/products', ProductController::class);
Route::group(['prefix' => 'products'], function () {
    Route::apiResource('/{product}/reviews', ReviewController::class);
}); 