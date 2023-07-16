<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartsController extends Controller
{
    public function index()
    {
        $title = 'Cart';
        $active = 'cart';
        $cart = session('cart.items', []);

        $subTotal = 0;
        foreach($cart as $item){
            $subTotal += $item['product']->price * $item['quantity'];
        }

        return view('customer.cart', compact('cart', 'title', 'active', 'subTotal'));
    }

    public function add(Product $product)
    {
        $cartItems = session('cart.items', []);
        $check = Cart::where('product_id', $product->id)->first();
        if (isset($cartItems[$product->id]) && $check != null ){
            $cartItems[$product->id]['quantity']++;
            $cartItems[$product->id]['sub_total'] = $product->price * $cartItems[$product->id]['quantity'];
            Cart::where('product_id', $product->id)->increment('quantity');

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

            Cart::create($cartItem);

        }


        session(['cart.items' => $cartItems]);

        return redirect()->back()->with('sweet_alert', [
            'icon' => 'success',
            'title' => 'success',
            'text' => 'Product '.$product->name.' has been added to cart!'
        ]);
    }

    public function destroy($id)
    {
        $cartItems = session('cart.items', []);

        if (isset($cartItems[$id])) {
            unset($cartItems[$id]);
            session(['cart.items' => $cartItems]);
        }
        return redirect()->back();
    }
}
