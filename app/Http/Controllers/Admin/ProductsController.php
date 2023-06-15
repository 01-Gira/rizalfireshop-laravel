<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;
use Illuminate\Support\Facades\Session;
// use App\DataTables\ProductsDataTable;


class ProductsController extends Controller
{
    
    public function index(){

        return view('admin.product.products', [
            'title' => 'Products',
            'active' => 'products',
            'categories' => Category::all()
        ]);
    }

    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            // $data = DB::table(DB::raw("(

            $data = DB::table('products as a')
                    ->select('a.name', 'a.stock', 'a.price', 'a.slug', 'b.name as category_name', 'b.id')
                    ->join('categories as b', 'a.category_id', '=', 'b.id');
                    // ->get();

            // $data = Product::all();

            if (!empty($request->get('category'))) {
                if ($request->get('category') != 0) {
                    $data->where('category_id', $request->get('category'));
                }
            }

            return DataTables::of($data)
            ->editColumn('checkall', function($row){
                $var = '<center>';
                $var .= '<input type="checkbox" name="check[]" value="'.$row->slug.'" id="checkbox-row">';
                $var .= '</center>';
                return $var;
            })
            ->editColumn('action', function($row) {
                $var = '<center>';
                $var .= '<a href="'.route('products.edit', base64_encode($row->slug)).'" type="button" class="btn btn-xs btn-warning" style="margin-right: 3px;" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fas fa-pencil-alt"></i></a>';
                $var .= '<button type="button" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="deleteData(\''.base64_encode($row->slug).'\')"><i class="fas fa-trash"> </i></button>';
                
                $var .= '</center>'; 
                return $var;
            })
            ->rawColumns(['checkall', 'action'])
            ->make(true);
        }else {
            return view('');
        }
    }


    public function create(){
        $title = 'Products';
        $active = 'add_product';
        $categories = Category::all();
        return view('admin.product.create', compact('title', 'active', 'categories'));
    }

    public function store(Request $request){
        dd($request->all());
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

        return redirect('/admin/products')->with('flash_notification', ['level' => 'success', 'message' => 'Product has been added!']);
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
    
    public function edit($slug)
    {
        return view('admin.product.edit', [
            'categories' => Category::all(),
            'product' => Product::where('slug', $slug)->first(), 
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
            'weight' => ['required'],
            'category_id' => ['required'],
            'image' => ['image','file','max:1024']
        ]);

        if ($request->slug != $product->slug){
            $validatedData['slug']= $request->slug;
        }

        if ($request->file('image')){
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        dd($validatedData);
        // $product->update($validatedData);

        return redirect('/admin/products')->with('flash_notification',['level' => 'success', 'message' => 'Product has been updated!']);
    }

    public function destroy(Request $request, $p)
    {
        try {
            $slug = base64_decode($p);
            // dd($slug);
            $check = Product::where('slug', $slug)->first();
            // dd($ch)
            if ($check) {
                if ($check->image) {
                    Storage::delete($check->image);
                }
                
                $indctr = 0;
                $msg = 'Product '.$check->name.' has been deleted successfully!';

                $check->delete();
                
                return response()->json([ 'indctr' => $indctr, 'msg' => $msg]);
                // return route('products.index')->with('flash_notification', ['level' => 'danger', 'message' => 'Product has been deleted!']);
            } else {
                $indctr = 1;
                $msg = 'Data product is not found!';

                return response()->json([ 'indctr' => $indctr, 'msg' => $msg]);
            }
        } catch (Exception $e) {
            Session::flash("flash_notification", [
                "level" => "danger",
                "message" => 'Error : '.$e->getMessage()
            ]);
            return redirect()->back();

        }
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);
        return response()->json(['slug' => $slug]);
    }

    public function updateStock(Request $request, Product $product)
    {
        $stock = $request->input('stock');
        $product->updateStock($stock);


        return redirect()->back()->with('flash_notification',['level' => 'success', 'message' => 'Product stock has been updated!']);
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
