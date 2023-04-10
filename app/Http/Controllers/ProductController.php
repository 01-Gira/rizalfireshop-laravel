<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, $search = null) {
        // return view('customer.shop', [
        //     'title' => 'Shop',
        //     'active' => 'shop',
        //     'products' => Product::paginate(9)
        // ]);
        $products = Product::query();
        $categories = Category::all();

        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

            
        // Filter by search keyword
        if (!is_null($search)) {
            $products->where('name', 'LIKE', '%'.$search.'%')
                        ->orWhere('category','LIKE', '%'.$search.'%');
        }

        // Filter by price range
        if ($min_price && $max_price) {
            $products->whereBetween('price', [$min_price, $min_price]);
        }

         // Filter by product name
        if ($request->filled('name')) {
          $products->where('name', 'like', '%' . $request->input('name') . '%');
        }
      
        // Filter by category
        if ($request->filled('category')) {
            $products->where('category_id', $request->input('category'));
        }
      
        // Check if any filters applied
        if ($min_price || $max_price || $request->filled('name') || $request->filled('category')) {
            $filtered_products = $products->paginate(9);
        } else {
            $filtered_products = Product::paginate(9);
        }
      
        return view('customer.shop', [
            'title' => 'Shop',
            'active' => 'shop',
            'products' => $filtered_products,
            'cart' => session('cart.items', []),
            'categories' => $categories,
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
