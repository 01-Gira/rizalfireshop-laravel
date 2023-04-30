<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('admin.order.index', [
            'title' => 'Orders',
            'active' => 'orders',
            'orders' => Order::latest()->filter(request(['search','status_transaction','sort']))->paginate(7)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Order::destroy($id);
        return redirect('/admin/orders')->with('danger', 'Order has been deleted!');
    }

    public function add_resi(Request $request, Order $order) 
    {
        $validatedData = $request->validate([
            'no_resi' => ['required']
        ]);

        $order->no_resi = $validatedData['no_resi'];
        $order->transaction_status = 'delivered';
        $order->save();

        return redirect()->back()->with('success','No Resi has been addedd');
    }
}
