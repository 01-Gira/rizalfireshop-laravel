<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;



class ProductsController extends Controller
{
    
    public function index(){
   
        // return view('admin.product.products', compact('title', 'active', 'products', 'categories'));
        return view('admin.product.products', [
            'title' => 'Products',
            'active' => 'products',
            'products' => Product::latest()->filter(request(['search', 'category', 'sort', 'min_price' && 'max_price']))->paginate(7)->withQueryString(),
            'categories' => Category::all()
        ]);
    }


    public function create(){
        $title = 'Products';
        $active = 'add_product';
        $categories = Category::all();
        return view('admin.product.create', compact('title', 'active', 'categories'));
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => ['required', 'max:70'],
            'slug'  => ['required', 'unique:products'],
            'description' => ['required','max:255'],
            'stock' => ['required'],
            'price' => ['required'],
            'category_id' => ['required'],
            'weight' => ['required'],
            'image' => ['image','file','max:1024']
        ]
        );
        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('products-images');
        }
        Product::create($validatedData);

        return redirect('/admin/products')->with('success', 'Produk has been added!');
        // return $request;
    }

    public function show(Product $product){
        // $title = 'Products';
        // $active = 'products';
        // $products = $product;
        // return view('admin.product.show',compact('title','active','products'));
        return view('admin.product.show', [
            'product' => $product, 
            'title' => 'Products', 
            'active' => 'products'], );
    }
    
    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'categories' => Category::all(),
            'product' => $product, 
            'title' => 'Products', 
            'active' => 'products'], );
    }

    public function update(Request $request, Product $product)
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

        return redirect('/admin/products')->with('success', 'Product has been updated!');
    }

    public function destroy(Product $product)
    {
        if($product->image){
            Storage::delete($product->image);
        }
        Product::destroy($product->id);
        return redirect('/admin/products')->with('danger', 'Product has been deleted!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
        // $name = $request->name ?? ''; // if $request->name is null, set $name to empty string
        // $slug = SlugService::createSlug(Product::class, 'slug', $name);
        // return response()->json(['slug' => $slug]);
    }

    public function updateStock(Request $request, Product $product)
    {
        $stock = $request->input('stock');
        $product->updateStock($stock);


        return redirect()->back()->with('success', 'Product stock updated successfully!');
    }
}
