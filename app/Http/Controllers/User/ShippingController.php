<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\RajaOngkirService;

class ShippingController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function getProvinces()
    {
        $provinces = $this->rajaOngkir->provinces();
        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $cities = $this->rajaOngkir->cities($request->province_id);
        return response()->json($cities);
    }

    public function getCost(Request $request)
    {
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $weight = $request->input('weight');
        $courier = $request->input('courier');

        $costs = $this->rajaOngkir->cost($origin, $destination, $weight, $courier);
        return response()->json($costs);
    }

}
