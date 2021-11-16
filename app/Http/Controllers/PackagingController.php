<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packaging;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Size;
use DB;
class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packaging = new Packaging;
        $packaging = $packaging->readAll();
        return view('admin.packaging.index', compact('packaging'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sizes = Size::all();
        return view('admin.packaging.create', compact('categories', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'sku' => 'required|unique:packaging',
        ]);

        $images=array();

        if($files=$request->file('images')){
            foreach($files as $file){
                $folder_to_save = 'product';
                $image_name = uniqid() . "." . $file->extension();
                $file->move(public_path('images/' . $folder_to_save), $image_name);
                $images[] = $folder_to_save . "/" . $image_name;
            }
        }

        Packaging::create($request->all());
        foreach ($images as $key => $data) {
            DB::table('product_images')
            ->insert([ 
                'sku' => $request['sku'],
                'image' => $data
            ]);
        }

        return redirect()->back()
            ->with('success', 'Packaging was created.'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Packaging $packaging)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $images = DB::table('product_images')->where('sku',$packaging->sku)->get();

        return view('admin.packaging.edit', compact('packaging', 'categories', 'subcategories', 'images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packaging $packaging)
    {
        $images=array();
        
        if($files=$request->file('images')){
            foreach($files as $file){
                $folder_to_save = 'product';
                $image_name = uniqid() . "." . $file->extension();
                $file->move(public_path('images/' . $folder_to_save), $image_name);
                $images[] = $folder_to_save . "/" . $image_name;
            }
        }

        $packaging->update($request->all());

        foreach ($images as $key => $data) {
            DB::table('product_images')
            ->insert([ 
                'sku' => $packaging->sku,
                'image' => $data
            ]);
        }

        return redirect()->back()
            ->with('success', 'Packaging was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $packaging = Packaging::findOrFail($id);
        if ($packaging->delete()) {
            return response()->json([
                'status' =>  'success',
                'message' => 'Packaging was deleted.'
            ], 200);
        }

        return response()->json([
            'status' =>  'error',
            'message' => 'Deleting packaging failed.'
        ], 200);
    }
}
