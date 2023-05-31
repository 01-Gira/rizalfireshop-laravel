<?php

use App\Http\Controllers\Admin\LoginController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\ProductsApiController;
use App\Http\Controllers\Api\Admin\CategoriesApiController;
use App\Http\Controllers\Api\Admin\OrdersApiController;
use App\Http\Controllers\Api\Admin\CustomersApiController;
use App\Http\Controllers\Api\Customer\OrdersApiController as OrdersCustomer;
use App\Http\Controllers\Api\Customer\AuthenticateApiController as CustomerAuth;
use App\Http\Controllers\Api\Customer\ProductsApiController as CustomerProducts;


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

Route::prefix('/')->group(function(){
    Route::post('login', [CustomerAuth::class, 'authenticate']);
    Route::post('register', [CustomerAuth::class, 'register']);

    Route::get('/products', [CustomerProducts::class, 'index']);
    Route::get('/products/{id}', [CustomerProducts::class, 'show']);

    Route::group(['middleware' => ['auth:sanctum', 'ability:customer']], function() {
        Route::get('/orders', [OrdersCustomer::class, 'index']);
        Route::get('/logout', [CustomerAuth::class, 'logout']);
    });
});


Route::prefix('/admin')->group(function(){
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function() {
        Route::get('/products', [ProductsApiController::class, 'index']);
        Route::prefix('/products')->group(function(){
            Route::get('/{id}', [ProductsApiController::class, 'show']);
            Route::post('/create', [ProductsApiController::class, 'store']);
            Route::put('/{id}/update', [ProductsApiController::class, 'update']);
            Route::delete('/{id}/delete', [ProductsApiController::class, 'destroy']);
        });

        Route::get('/categories', [CategoriesApiController::class, 'index']); 
        Route::prefix('/categories')->group(function(){
            Route::get('/{id}', [CategoriesApiController::class, 'show']);
            Route::post('/create', [CategoriesApiController::class, 'store']);
            Route::put('/{id}/update', [CategoriesApiController::class, 'update']);
            Route::delete('/{id}/delete', [CategoriesApiController::class, 'destroy']);
        });

        Route::get('/orders', [OrdersApiController::class, 'index']);
        Route::prefix('/orders')->group(function(){
            Route::get('/{id}', [OrdersApiController::class, 'show']);
        });

        Route::get('/customers', [CustomersApiController::class, 'index']);

        Route::get('/logout', [LoginController::class, 'logout']);
    });
});


// Route::get('/admin/logout', [LoginController::class, 'logout'])->middleware(['auth:sanctum', 'ability:admin']);


Route::post('/payment-handler', [OrderApiController::class, 'payment_handler']);

// Route::apiResource('/products',[ProductsApiController::class]);


