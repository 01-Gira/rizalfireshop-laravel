<?php

use App\Http\Controllers\Admin\LoginController;

use App\Http\Controllers\User\LoginController as CustomerLogin;
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

Route::prefix('/')->group(function(){
    Route::post('login', [CustomerLogin::class, 'authenticate']);

    Route::get('/products', [ProductsApiController::class, 'index']);
    Route::get('/products/{id}', [ProductsApiController::class, 'show']);

    Route::group(['middleware' => ['auth:sanctum', 'ability:customer']], function() {
        Route::get('/logout', [CustomerLogin::class, 'logout']);
    });
});


Route::prefix('/admin')->group(function(){
    Route::post('/login', [LoginController::class, 'authenticate']);
    Route::group(['middleware' => ['auth:sanctum', 'ability:admin']], function() {
        
    Route::get('/products', [ProductsApiController::class, 'index']);
    Route::prefix('/products')->group(function(){
        Route::post('/create', [ProductsApiController::class, 'store']);
        Route::put('/{id}/update', [ProductsApiController::class, 'update']);
        Route::delete('/{id}/delete', [ProductsApiController::class, 'delete']);
    });
    Route::get('/logout', [LoginController::class, 'logout']);
    });
});


// Route::get('/admin/logout', [LoginController::class, 'logout'])->middleware(['auth:sanctum', 'ability:admin']);


Route::post('/payment-handler', [OrderApiController::class, 'payment_handler']);

// Route::apiResource('/products',[ProductsApiController::class]);


