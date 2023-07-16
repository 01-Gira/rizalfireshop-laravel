<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attribute;

use DB;
use DataTables;

class AtrributesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.attributes.index', [
            'title' => 'Attributes',
            'active' => 'attributes',
        ]);
    }


    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('attributes');

            return DataTables::of($data)
                ->editColumn('action', function($row) {
                    $var = '<center>';
                    $var .= '<a href="'.route('products.edit', base64_decode($row->name)).'" type="button" class="btn btn-warning" style="margin-right: 3px;" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fas fa-pencil-alt"></i></a>';
                    $var .= '<button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="deleteData(\''.base64_encode($row->name).'\')"><i class="fas fa-trash"> </i></button>';
                    
                    $var .= '</center>'; 
                    return $var;
                })
                ->rawColumns(['action'])
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
        return view('admin.attributes.create', [
            'title' => 'Attributes',
            'active' => 'attributes',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token']);
            
            Attribute::create($data);

            return redirect('/admin/attributes/index')->with('flash_notification', ['level' => 'success', 'message' => 'Attribute has been added!']);
        } catch (Exception $e) {
            return redirect('/admin/attributes/index')->with('flash_notification', ['level' => 'danger', 'message' => 'Error : '.$e->getMessage()]);

        }
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
        //
    }
}
