<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController as AdminLogin;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\User\CartsController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\OrderController;
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
        $products = Product::where('sale', '>', 0 )->take(3)->get();
        

        return view('customer.home', [
            'title' => "Home",
            'active' => "home",
            'cart' => session('cart.items', []),
            'products' => $products
        ]);

    });
    Route::post('login', 'LoginController@authenticate');
    Route::post('register', 'RegisterController@store');
    Route::get('shop',[ProductController::class,'index']);
    Route::get('shop/product/{product:slug}',[ProductController::class,'show']);
    Route::post('shop/product/add/{product}', 'ProductController@addCart')->name('product.add');

    Route::group(['middleware' => ['role:admin,role:customer,role:superadmin']], function(){
        Route::get('checkout', [CheckoutController::class, 'index']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::post('orders', [OrderController::class, 'payment_status']);
        Route::get('orders/{order:order_id}', [OrderController::class, 'show']);
        Route::post('checkout', [CheckoutController::class, 'store']);
        Route::post('checkout/cost', [CheckoutController::class, 'getCost']);

        Route::get('cart', [CartsController::class, 'index'])->name('cart.index');
        Route::post('cart/add/{product}', [CartsController::class,'add'])->name('cart.add');
        Route::delete('cart/{id}', [CartsController::class, 'destroy'])->name('cart.destroy');

        Route::get('province/{id}/cities', [CheckoutController::class, 'getCities']);
        Route::get('logout','LoginController@logout');
    });

 
});




Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    
    Route::match(['get','post'],'login','LoginController@authenticate');

    Route::group(['middleware' => ['auth']], function(){
        Route::get('dashboard','DashboardController@index');
        Route::get('get-new-order-count','DashboardController@newOrdersCount')->name('orders-count');
        Route::post('change-status', 'DashboardController@changeStatusOrders' )->name('change-status-orders');

        // Users
        Route::get('users', 'UsersController@index');
        Route::get('users/create', 'UsersController@create');
        

        // Product
        Route::get('products', 'ProductsController@index')->name('products.index');
        Route::get('products/dashboard', 'ProductsController@dashboard')->name('products.dashboard');
        Route::get('products/edit-multiple', 'ProductsController@multipleEdit')->name('products.edit-multiple');
        Route::get('products/create', 'ProductsController@create');
        Route::post('products', 'ProductsController@store');


        Route::get('products/export','ProductsController@exportExcel');
        Route::get('products/checkSlug','ProductsController@checkSlug');
        Route::put('products/{product:slug}/update-stock', 'ProductsController@updateStock')->name('products.update-stock');
        Route::delete('products/{param}', 'ProductsController@destroy')->name('products.destroy');
        Route::get('products/destroy-multiple', 'ProductsController@multipleDelete')->name('products.destroy-multiple');
        Route::get('products/edit/{slug}', 'ProductsController@edit')->name('products.edit');

        // Category
        Route::get('categories/dashboard', 'CategoriesController@dashboard')->name('categories.dashboard');
        Route::delete('categories/{param}', 'CategoriesController@destroy')->name('categories.destroy');
        Route::resource('categories', CategoriesController::class);

        // Tag
        Route::get('tags/index', 'TagsController@index');
        Route::get('tags/create', 'TagsController@create');
        Route::post('tags/store', 'TagsController@store');
        Route::get('tags/dashboard', 'TagsController@dashboard')->name('tags.dashboard');


        Route::get('attributes/index', 'AtrributesController@index');
        Route::get('attributes/dashboard', 'AtrributesController@dashboard')->name('attributes.dashboard');
        Route::get('attributes/create', 'AtrributesController@create');
        Route::post('attributes/store', 'AtrributesController@store');


        // Order
        Route::put('orders/add-no-resi', 'OrdersController@add_resi')->name('orders.add-resi');
        Route::get('orders/dashboard', [OrdersController::class, 'dashboard'])->name('orders.dashboard');
        // Route::get('orders/index', 'OrdersC')
        Route::resource('orders', OrdersController::class);
        Route::get('logout',[AdminLogin::class,'logout']);
    });
        
});