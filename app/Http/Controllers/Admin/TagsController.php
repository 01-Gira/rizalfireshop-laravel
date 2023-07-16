<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use DB;
use DataTables;
use Carbon\Carbon;


class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tag.index', [
            'title' => 'Tags',
            'active' => 'tags',
        ]);
    }


    public function dashboard(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('tags')
                    ->orderBy('updated_at', 'DESC');

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
        return view('admin.tag.create', [
            'title' => 'Tags',
            'active' => 'tags',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $except_token = $request->except(['_token']);
            // dd($except_token);
            $storeData = [];

            for ($i=0; $i < count($except_token['name']); $i++) { 

                $data = [
                    'name' => $except_token['name'][$i],
                    'created_at'=> Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
                $storeData[] = $data;
            }
            // dd($storeData);

            Tag::insert($storeData);


    

            return redirect('/admin/tags/index')->with('flash_notification', ['level' => 'success', 'message' => 'Tags has been added!']);

        } catch (Exception $e) {
            return redirect('/admin/tags/index')->with('flash_notification', ['level' => 'danger', 'message' => 'Error : '.$e]);

            //throw $th;
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
