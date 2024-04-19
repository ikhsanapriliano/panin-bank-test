<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::prefix('products')->group(function() {
        Route::post('/', [ProductController::class, 'createProduct'])->middleware('admin');
        Route::get('/{id}', [ProductController::class, 'findProductById'])->middleware('admin');
        Route::get('/', [ProductController::class, 'findManyProducts'])->middleware('user');
        Route::put('/{id}', [ProductController::class, 'updateProduct'])->middleware('admin');
        Route::delete('/{id}', [ProductController::class, 'deleteProduct'])->middleware('admin');
    });

    Route::prefix('orders')->group(function() {
        Route::post('/', [OrderController::class, 'createOrder'])->middleware('user');
        Route::get('/{id}', [OrderController::class, 'findOrderById'])->middleware('user');
        Route::get('/', [OrderController::class, 'findAllOrders'])->middleware('admin');
    });

    Route::get('/token', function (Request $request) {
        $token = $request->session()->token();
        $token = csrf_token();

        return response()->json(['csrfToken' => $token], 200);
    });
});