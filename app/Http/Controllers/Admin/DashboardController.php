<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $title = 'Dashboard';
        $active = 'dashboard';
        return view('admin.dashboard', compact('title', 'active'));
    }

    public function newOrdersCount(){
        $newOrdersCount = Order::where('status_order', 'new')->count();

        return response()->json((['newOrdersCount' => $newOrdersCount]));
    }

    public function changeStatusOrders(Request $request){

        // dd($request->status);
        // Ambil status yang dikirim dari ajax
        $status = $request->status;
        // dd($status);
        // $orders = Order::where('status', 'new')->get();
    
            // Ubah status semua order menjadi 'old'
        Order::where('status_order', 'new')->update(['status_order' => $status]);

        // Kirim response ke ajax
        return response()->json(['status' => 'success', 'message' => 'Order status has been updated to '.$status]);

    }

}
