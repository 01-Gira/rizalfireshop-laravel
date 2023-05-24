<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryDetailResource;



class CategoriesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        // return response()->json([])
        return CategoryResource::collection($categories);
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
        try {
            $validatedData = $request->validate([
                'name' => ['required'],
                'slug' => ['required', 'unique:categories'],
                'image' => ['image','file','max:1024'],
            ]);
    
            if ($request->file('image')){
                $validatedData['image'] = $request->file('image')->store('products-images');
            }

            Category::create($validatedData);
    
            return response()->json(['msg'=>'Category has been created successfully!']);
        } catch (Exception $e) {
            return response()->json(['msg'=>'Error : '.$e->getMessage()]);
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
      
        // return response()->json(['data' => $category]);
        return new CategoryDetailResource($category);
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
        try {
            $category = Category::findOrFail($id);

            if (!$category) {
                return response()->json(['msg'=>'Product not found!']);
            }

            $validatedData = $request->validate([
                'name' => ['required'],
                'image' => ['image','file','max:1024'],
            ]);
    
         
            $rules = ['slug' => ['required', 'unique:categories']];
            if ($request->slug != $category->slug) {
                $validatedData['slug'] = $request->slug;
            }

            // if ($request->slug != $product->slug){
            //     $rules['slug'] = ['required', 'unique:products'];
            // }

            if ($request->file('image')){
                $validatedData['image'] = $request->file('image')->store('post-images');
            }

            
            $category->update($validatedData);
    
            return response()->json(['msg'=>'Category has been updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['msg'=>'Error : '.$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            if($category->image){
                Storage::delete($category->image);
            }
            Category::destroy($category->id);
            return response()->json(['msg'=>'Category has been deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['msg'=>'Error : '.$e->getMessage()]);
        }

    }
}
