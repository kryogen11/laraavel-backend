<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

// Route::get('/user', function (Request $request) {
//    return $request->user();
// })->middleware('auth:sanctum');

Route::group(['prefix' => 'v1/auth'], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group(['middleware' => 'checktoken'], function() {
        Route::post('logout', [AuthController::class, 'logout']);
    }); 
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['middleware' => 'checktoken'], function() {
        Route::get('product', [ProductController::class, 'getProduct']);
        Route::post('product', [ProductController::class, 'createProduct']);
        Route::put('product/{id}', [ProductController::class, 'editProduct']);
        Route::delete('product/{id}', [ProductController::class, 'deleteProduct']);
    });
});