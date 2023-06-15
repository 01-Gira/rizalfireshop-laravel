<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use DataTables;
use DB;

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


    public function dashboard(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $data = DB::table('orders as a')
                ->select('a.order_id', 'a.customer_id','a.courier', 'a.total_price', 'a.transaction_status', 'a.status_order', 'a.transaction_id', 'b.id', 'b.name')
                ->join('customers as b', 'a.customer_id', '=', 'b.id');

            return DataTables::of($data)
            ->editColumn('action', function($row) {
                $var = '<center>';
                if ($row->transaction_status == 'capture') {
                    $var .= '<button type="button" class="btn btn-success btn-xs" style="margin-right: 3px;" data-toggle="tooltip" data-placement="top" title="Add No Resi" onclick="addNoResi(\''.base64_encode($row->order_id).'\')"><i class="fas fa-truck"></i></button>';
                    $var .= '<a href="#" type="button" class="btn btn-warning btn-xs" style="margin-right: 3px;" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fas fa-pencil-alt"></i></a>';
                    $var .= '<button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(\''.($row->order_id).'\')"><i class="fas fa-trash"> </i></button>';
                }else {
                    $var .= '<a href="#" type="button" class="btn btn-warning btn-xs" style="margin-right: 3px;" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fas fa-pencil-alt"></i></a>';
                    $var .= '<button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(\''.($row->order_id).'\')"><i class="fas fa-trash"> </i></button>';
                }
               
                $var .= '</center>'; 
                return $var;
            })
            ->make(true);
        }else {
            return view('');
        }
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

    public function add_resi(Request $request, $p) 
    {
        dd($p);
        try {
            // dd($request->param);
            $order_id = base64_decode($request->input('param'));
            dd($order_id);
            $validatedData = $request->validate([
                'no_resi' => ['required']
            ]);
            // dd($validatedData);
            $order = Order::where('');
            $order->no_resi = $validatedData['no_resi'];
            $order->transaction_status = 'delivered';
            $order->save();
    
            return redirect()->back()->with('success','No Resi has been addedd');
        } catch (Exception $e) {
            //throw $th;
        }
       
    }
}
