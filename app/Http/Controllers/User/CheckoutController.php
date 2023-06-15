<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\MidtransService;
use App\Http\Services\RajaOngkirService;
use App\Models\City;
use App\Models\Courier;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{

    protected $rajaOngkirService;
    protected $midtransService;

    public function __construct(RajaOngkirService $rajaOngkirService, MidtransService $midtransService)
    {
        $this->rajaOngkirService = $rajaOngkirService;
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {

        $title = 'Cart';
        $active = 'cart';
        $cart = session('cart.items', []);
        $product = Product::all();

        if ($cart == null){
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'error',
                'title' => 'Cart Empty!',
                'text' => 'Your cart is empty!',
            ]);
        }elseif(!Auth::guard('customer')->check()){
            return redirect()->back()->with('sweet_alert', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'You need to login first to access checkout!',
            ]);
        }else{
            $cart = session('cart.items', []);
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

    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => ['required', 'max:70'],
                'last_name' => ['required', 'max:120'],
                'street_address' => ['required', 'max:120'],
                'province' => ['required'],
                'city_destination' => ['required'],
                'district' => ['required'],
                'postal_code' => ['required'],
                'phone' => ['required', 'max:13'],
                'email' => ['required','email:dns'],
                'courier' => ['required'],
                'courier_service' => ['required'],
                'total_price' => ['required'],
                'weight' => ['required'],
            ]);
    
            $province_name = Province::findorFail($validatedData['province']);
            $city_name = City::findorFail($validatedData['city_destination']);
            $validatedData['province'] = $province_name->title;
            $validatedData['city_destination'] = $city_name->title;
    
            $validatedData['name'] = $validatedData['first_name'] . ' ' . $validatedData['last_name'];
            $validatedData['address'] = $validatedData['street_address'] . ', ' . $validatedData['district']
            . ', ' . $validatedData['city_destination'] . ', ' . $validatedData['province'] . ', ' . $validatedData['postal_code'];
            unset(
                $validatedData['first_name'], 
                $validatedData['last_name'],
                $validatedData['street_address'],
                $validatedData['district'],
                $validatedData['city_destination'] ,
                $validatedData['province'],
                $validatedData['postal_code']
            );
            
            $validatedData['customer_id'] = auth()->guard('customer')->user()->id;
    
            // dd($validatedData);
    
            $date = date('YmdHis');
            $websiteName = 'Rizal Fire Shop';
            $id = $date . '-' . str_replace(' ', '', $websiteName);
            $order = new Order($validatedData);
            $order->order_id = $id;
            // $order->status_order = 'old';
            $order->save();
          
            $cartItems = session('cart.items', []);
    
            // dd($cartItems);
            // $order->products()->sync($cartItems);
    
            $itemDetails = [];
            foreach ($cartItems as $item) {
                // dd($item);
                $product = Product::find($item['id']);  
                if ($product == null) {
   
                    return redirect('/checkout')->with('sweet_alert',[
                        'icon' => 'error',
                        'title' => 'Product Is Out Of Stock',
                        'text' => 'Product ' .$item['name']. ' is out of stock',
                    ]);
                }else {
                    $product->stock -= $item['quantity'];
                    $product->sale += $item['quantity'];
                    $product->save();
        
                    
                    $itemDetail = [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'name' => $product->name,
                        'price' => $item['sub_total'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    // dd($itemDetail);
                    $itemDetails [] = $itemDetail;
                }  
            }
            // dd($itemDetails);
    
            $order->products()->attach($itemDetails);
            // dd($itemDetails);
            // $itemDetails = array_map(function($item) {
            //     $item['id'] = $item['product_id'];
            //     unset($item['product_id']);
            //     return $item;
            // }, $itemDetails);
            
            // foreach($itemDetails as $itemDetail){
                $transactionParams = array(
                    'transaction_details' => array(
                        'order_id' => $order->order_id,
                        'gross_amount' => $order->total_price,
                    ),
                    
                    'item_details' => $itemDetails,
                    'customer_details' => array(
                        'name' => $order->name,
                        'email' => $order->email,
                        'phone' => $order->phone,
                    ),
                );
            // }
    
            $snapToken = $this->midtransService->checkout($transactionParams);
            $order->snap_token = $snapToken;
            $order->save();
    
    
            // dd($order);
            session()->forget('cart.items');
            // Order::create($validatedData);
            return redirect('/orders')->with('sweet_alert', [
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Order with order id ' . $order->order_id . ' has been created! Please procced with the payment',
    
            ]);
        } catch (Exception $e) {
            return redirect('/orders')->with('sweet_alert', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error : '.$e->getMessage(),
    
            ]);
        }
       
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');

        return json_encode($city);
    }

    public function getCost(Request $request)
    {
        $courier = $request->courier;
        $destination = $request->city_destination;
        $weight = $request->weight;

        $costs = $this->rajaOngkirService->cost($destination, $weight, $courier);


        if (!is_null($costs)) {
            return response()->json($costs);
        } else {
            return response()->json(['message' => 'Failed to get shipping cost.']);
        }
        
    }


}
