<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersApiController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->id;
        $orders = Order::findOrFail('customer_id', $user);

        return $orders();
    }
}
