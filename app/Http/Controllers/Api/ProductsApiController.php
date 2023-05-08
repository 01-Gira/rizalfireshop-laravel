<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        // return response()->json(['data' => $products]);
        return ProductResource::collection($products);
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
        $validatedData = $request->validate([
            'name' => ['required', 'max:70'],
            'slug'  => ['required', 'unique:products'],
            'description' => ['required','max:255'],
            'stock' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
            'weight' => ['required'],
            'image' => ['image','file','max:1024']
        ]);

        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('products-images');
        }
        Product::create($validatedData);

        return response()->json(['msg' => 'Product has been added! Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        // return response()->json(['data' => $product]);
        return new ProductDetailResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['required','max:255'],
            'stock' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
            'image' => ['image','file','max:1024']
        ]);

        if ($request->slug != $product->slug){
            $rules['slug'] = ['required', 'unique:products'];
        }

        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        // dd($validatedData);
        $product->update($validatedData);

        return response()->json(['msg'=>'Product has been updated! Successfully']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json(['msg'=>'Product not found!']);
        }

        $validatedData = $request->validate([
            'name' => ['required', 'max:255'],
            'description' => ['required','max:255'],
            'stock' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
            'image' => ['image','file','max:1024']
        ]);

        $rules = ['slug' => ['required', 'unique:products']];
        if ($request->slug != $product->slug) {
            $validatedData['slug'] = $request->slug;
        }

        // if ($request->slug != $product->slug){
        //     $rules['slug'] = ['required', 'unique:products'];
        // }

        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        $product->update($validatedData);

        return response()->json(['msg' => 'Product has been updated! Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
