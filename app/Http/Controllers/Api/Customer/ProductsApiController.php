<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    public function index()
    {
        try {
            $products = Product::latest()->where('stock', '>', 0)->filter(request(['search', 'category', 'sort', 'min_price' && 'max_price']))->paginate(9)->withQueryString(),


            return new ProductResource($products);
        } catch (Exception $e) {
            return response()->json(['error'=>true, 'message' => 'Error : '.$e->getMessage()]);
        }
    }

    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            // return response()->json(['data' => $product]);
            return new ProductDetailResource($product);
        } catch (Exception $e) {
            return response()->json(['error'=> true,'message' => 'Error : '.$e->getMessage()]);
        }
    }
}
