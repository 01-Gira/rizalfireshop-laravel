<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function addCart(Request $request, Product $product)
    {
        dd($product);       
        $cartItems = session('cart.items', []);
        if (isset($cartItems[$product->id])){
            $cartItems[$product->id]['quantity']++;
            $cartItems[$product->id]['sub_total'] = $product->price * $cartItems[$product->id]['quantity'];
        }else {
            $cartItems[$product->id] = [
                'id' => $product->id,
                'product'=> $product,
                'name' => $product->name,
                'quantity'=> 1,
                'sub_total' => $product->price,
            ];

                      $cartItem = [
                'customer_id' => Auth::guard('customer')->id(),
                'product_id' => $product->id,
                'name' => $product->name,
                'quantity'=> 1
            ]; 
        }

        session(['cart.items' => $cartItems]);
        // dd($cartItems);
        // return redirect()->route('cart.index');
        return redirect()->back()->with('sweet_alert', [
            'icon' => 'success',
            'title' => 'success',
            'text' => 'Product '.$product->name.' has been added to cart!'
        ]);
    }
}
