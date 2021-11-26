<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Packaging;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Size;
use App\Models\ProductPrice;
use DB;
use Cache;
class PackagingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductPrice $product_volume)
    {
        $packaging = new Packaging;
        $packaging = $packaging->readAll();
        return view('admin.packaging.index', compact('packaging', 'product_volume'));
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

        foreach ($images as $key => $data) {
            DB::table('product_images')
            ->insert([ 
                'sku' => $request['sku'],
                'image' => $data
            ]);
        }
   
        if ($request['volumes'] != null) {
            $volumes = explode(",",$request['volumes']);
            
            foreach ($volumes as $key => $data) {
         
                DB::table('product_price')
                ->insert([ 
                    'sku' => $request['sku'],
                    'volume' => $data,
                    'price' => $request['prices'][$key]
                ]);
            }
        }
        return redirect()->back()
            ->with('success', 'Packaging was created.'); 
    }

    public function readPricePerVolume($sku)
    {
        $product_price = new ProductPrice;
        return $product_price->readPricePerVolume($sku);
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
    public function edit(Packaging $packaging, ProductPrice $product_price)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $images = DB::table('product_images')->where('sku',$packaging->sku)->get();

        $volumes = $product_price->readVolumes($packaging->sku);
        return view('admin.packaging.edit', compact('packaging', 'categories', 'subcategories', 'images', 'volumes'));
    }

    public function removePricePerVolume(ProductPrice $p) 
    {
        return $p->removePricePerVolume(request()->sku, request()->volume);
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
        if ($request['volumes'] != null) {
            $volumes = explode(",",$request['volumes']);

            foreach ($volumes as $key => $volume) {
                if ($this->isVolumeExists($request['sku'], $volume)) { 
                    DB::table('product_price')
                    ->where('sku', $request['sku'])
                    ->where('volume', $volume)
                    ->update([ 
                        'price' => $request['prices'][$key]
                    ]);
                }
                else {
                    DB::table('product_price')
                    ->insert([ 
                        'sku' => $request['sku'],
                        'volume' => $volume,
                        'price' => $request['prices'][$key]
                    ]);
                   
                }
            }

            
        }
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

    public function isVolumeExists($sku, $volume) {
        $res = DB::table('product_price')
                    ->where('sku', $sku)
                    ->where('volume', $volume)->get();
        return count($res) > 0 ? true : false;
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

    
    public function deletePackagingCache() {
        Cache::forget('packaging-cache');
        return redirect()->back()->with('success', 'Cache was deleted');
    }
}
