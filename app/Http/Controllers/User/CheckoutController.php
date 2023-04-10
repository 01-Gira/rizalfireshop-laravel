<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\RajaOngkirService;
use App\Models\City;
use App\Models\Courier;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{

    protected $rajaOngkirService;

    public function __construct(RajaOngkirService $rajaOngkirService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
    }

    public function index(Request $request)
    {

        $title = 'Cart';
        $active = 'cart';
        $cart = session('cart.items', []);
        $product = Product::all();

        $subTotal = 0;
        $weight = 0;

        foreach($cart as $item){
            $subTotal += $item['product']->price * $item['quantity'];
            $weight += $item['product']->weight * $item['quantity'];
        }


        // get province and courier
        $couriers = Courier::pluck('title','code');
        $provinces = Province::pluck('title','province_id');

        return view('customer.checkout', compact(
            'title',
            'active',
            'cart',
            'product',
            'subTotal',
            'provinces',
            'couriers',
            'weight'
        
        ));
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');

        return json_encode($city);
    }

    public function getCost(Request $request)
    {

        $weight = $request->weight;

       
        $destination = $request->city_destination;
        $courier = $request->courier;

        // dd($destination);


        $costs = $this->rajaOngkirService->cost($destination, $weight, $courier);


        if (!is_null($costs)) {
            dd($costs);
            return response()->json($costs);
        } else {
            return response()->json(['message' => 'Failed to get shipping cost.']);
        }

        
    }


}
