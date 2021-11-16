<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Closures;
use App\Models\Packaging;
use App\Models\Category;

class ClosuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $closures = new Closures;
        $closures = $closures->readAll();
        return view('admin.closures.index', compact('closures'));
    }

    public function readClosuresByPackaging($packaging_id) {
        $closures = new Closures;
        return $closures->readClosuresByPackaging($packaging_id);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.closures.create', compact('categories'));
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

        Closures::create($request->all());

        foreach ($images as $key => $data) {
            DB::table('product_images')
            ->insert([ 
                'sku' => $request['sku'],
                'image' => $data
            ]);
        }

        return redirect()->back()
            ->with('success', 'Closures was created.');
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
    public function edit(Closures $closure)
    {
        $packaging = Packaging::all();
        return view('admin.closures.edit', compact('closure', 'packaging'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required:closures',
        ]);

        Closures::where('id', $id)->update([
            'name' => $request->input('name'),
            'packaging_id' => $request->input('packaging_id')
        ]);

        return redirect()->back()
            ->with('success', 'Closures was updated.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $closures = Closures::findOrFail($id);
        if ($closures->delete()) {
            return response()->json([
                'status' =>  'success',
                'message' => 'Closure was deleted.'
            ], 200);
        }

        return response()->json([
            'status' =>  'error',
            'message' => 'Deleting closure failed.'
        ], 200);
    }
}
