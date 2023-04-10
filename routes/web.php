<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\CartsController;
use App\Http\Controllers\User\CheckoutController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::prefix('/')->namespace('App\Http\Controllers\User')->group(function(){
    Route::get('', function () {
        $products = Product::take(3)->get();

        return view('customer.home', [
            'title' => "Home",
            'active' => "home",
            'cart' => session('cart.items', []),
            'products' => $products
        ]);
    });

    Route::post('login', 'LoginController@authenticate');
    Route::get('shop',[ProductController::class,'index']);
    Route::group(['middleware'=>['customer']], function() {
        Route::get('checkout', [CheckoutController::class, 'index']);
        Route::post('checkout', [CheckoutController::class, 'getCost']);
        Route::get('province/{id}/cities', [CheckoutController::class, 'getCities']);
        Route::get('logout','LoginController@logout');
    });

    Route::get('cart', [CartsController::class, 'index'])->name('cart.index');
    Route::post('cart/add/{product}', [CartsController::class,'add'])->name('cart.add');
    Route::delete('cart/{id}', [CartsController::class, 'destroy'])->name('cart.destroy');
});




Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    Route::match(['get','post'],'login','LoginController@authenticate');

    Route::group(['middleware'=>['admin']], function(){
        Route::get('dashboard','DashboardController@index');
        Route::get('products/checkSlug','ProductsController@checkSlug');
        Route::resource('products', ProductsController::class);
        Route::get('logout',[AdminLogin::class,'logout']);
    });
        
});