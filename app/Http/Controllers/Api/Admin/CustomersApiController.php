<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersApiController extends Controller
{
    public function index()
    {
        try {
            $customers = Customer::all();

            if ($customers!= null) {
                $error = 'false';
                $msg = 'Data ditemukan';
            }else {
                $error = 'true';
                $msg = 'Data tidak ditemukan';
            }
            return response()->json([
                'error' => $error,
                'message' => $msg,
                'data'=>$customers
            ]);
        } catch (Exception $e) {
            return response()->json(['error'=> 'true', 'message' => 'Error : '.$e->getMessage()]);
        }
       
    }
}
