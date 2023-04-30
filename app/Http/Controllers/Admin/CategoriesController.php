<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.category.index', [
            'title' => 'Categories',
            'active' => 'categories',
            'categories' => Category::latest()->filter(request(['search']))->paginate(7)->withQueryString(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create', [
            'title' => 'Categories',
            'active' => 'categories',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:70'],
            'slug'  => ['required', 'unique:categories'],
            'image' => ['image','file','max:1024']
        ]);

        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('products-images');
        }
        Category::create($validatedData);

        return redirect()->back()->with('success', 'Category has been added!');
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
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'max:70'],
            'image' => ['image','file','max:1024']
        ]);

        if ($request->slug != $category->slug){
            $rules['slug'] = ['required', 'unique:products'];
        }

        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        // dd($validatedData);
        $category->update($validatedData);
        return redirect()->back()->with('success', 'Category has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->image){
            Storage::delete($category->image);
        }
        Category::destroy($category->id);
        return redirect()->back()->with('danger', 'Product has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }
}
