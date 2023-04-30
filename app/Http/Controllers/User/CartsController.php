<?php

namespace App\Http\Controllers\User;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

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
        }

        session(['cart.items' => $cartItems]);
        // dd($cartItems);
        // return redirect()->route('cart.index');
        return redirect()->back()->with('success', 'Product has been added to cart!');
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
