<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('customer.shop', [
            'title' => 'Shop',
            'active' => 'shop',
            'products' => Product::latest()->where('stock', '>', 0)->filter(request(['search', 'category', 'sort', 'min_price' && 'max_price']))->paginate(9)->withQueryString(),
            'cart' => session('cart.items', []),
            'categories' => Category::all()
        ]);
    }


    public function show(Product $product) {
        return view('customer.product', [
            'title' => 'Shop',
            'active' => 'shop',
            'cart' => session('cart.items', []),
            'product' => $product
        ]);
    }
}
