<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Notifications\OrderStatusNotification;
use App\Notifications\AdminOrderStatusNotification;



class OrderController extends Controller
{
    public function index() {
        $user_id = auth()->guard('customer')->user()->id;
        $cart = session('cart.items', []);
        return view('customer.orders', [
            'title' => 'Orders',
            'active' => 'orders',
            'cart' => $cart,
            'orders' => Order::where('customer_id', $user_id)->latest()->paginate(7)
        ]);
    }

    public function payment_status(Request $request) {
        try {
            $json = json_decode($request->get('json'));
            // dd($json);
            $order = Order::where('order_id', $request->input('order_id'))->first();
            $order->transaction_id = isset($json->transaction_id) ? $json->transaction_id : null;
            $order->payment_type = $json->payment_type;
            $order->payment_code = isset($json->payment_code) ? $json->payment_code : null;
            $order->transaction_status = isset($json->transaction_status) ? $json->transaction_status : null;
            $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;   
            // dd($order);
            $order->save();

            $user = auth()->guard('customer')->user();
            $admin = Admin()->where('role', 'package')->get();
            $user->notify(new OrderStatusNotification($order));
            $admin->notify(new AdminOrderStatusNotification($order, $user));

            return back()->with('sweet_alert',[
                'icon' => 'success',
                'title' => 'Success',
                'text' => 'Payment with ' . $order->order_id . ' is ' . $order->transaction_status
            ]);
        } catch (Exception $e) {
            return back()->with('sweet_alert',[
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Error :'.$e->getMesaage()
            ]);
        }
       
    }
}
