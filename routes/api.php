<?php

use App\Http\Controllers\Admin\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Api\ProductsApiController;
use App\Http\Controllers\OrderApiController;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payment-handler', [OrderApiController::class, 'payment_handler']);

// Route::apiResource('/products',[ProductsApiController::class]);

Route::get('/products', [ProductsApiController::class, 'index'])    ;
Route::get('/products/{id}', [ProductsApiController::class, 'show']);

Route::post('/admin/login', [LoginController::class, 'authenticate']);

