<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Packaging;
use App\Models\Size;
use App\Models\Variation;
use DB;
use App\Models\Closures;
use App\Models\ProductPrice;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = new Product;
        $product = $product->readAllProduct();
        return view('admin.products.index');
    }

    public function readAllProduct() {
        
        $product = new Product;
        $product = $product->readAllProduct();
        
        if(request()->ajax())
        { 
            return datatables()->of($product)
                ->addColumn('action', function($product)
                {
                    $button = ' <a class="btn btn-sm" data-id="'. $product->id .'" href="'. route('product.edit',$product->id) .'"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a data-id="'. $product->id .'" class="btn btn-archive-product" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-trash"></i></a>';
                    return $button;
                })
                ->addColumn('variation', function($product){ return $product->variation_id == 0 ? "None" : $product->variation; })
                ->addColumn('volumes', function($product){
                    $html = "";
                    $p = new ProductPrice;
                    $volumes = $p->readVolumes($product->sku);
                    $volumes = explode(",",$volumes);
                    foreach ($volumes as $data) {
                        $html .= '<span class="badge badge-primary m-1">'.$data.'</span>';
                    }
                    return $html;
                })
                ->addColumn('packaging', function($product){
                    $html = "";
                    if ($product->packaging) {
                        $packaging_ids = json_decode($product->packaging);
                        foreach ($this->readPackaging($packaging_ids) as $data) {
                            $html .= '<span class="badge badge-primary m-1">'. $data->name .' '. $data->size . '</span>';
                        }
                    }
                    return $html;
                })
                ->addColumn('closures', function($product){
                    $html = "";
                    if ($product->closures) {
                        $closures_ids = json_decode($product->closures);
                        foreach ($this->readClosures($closures_ids) as $data) {
                            $html .= '<span class="badge badge-primary m-1">'. $data->name .' '. $data->size . '</span>';
                        }
                    }
                    return $html;
                })
                ->rawColumns(['action','volumes', 'packaging', 'closures'])
                ->make(true);
        }
    }

    public function readPackaging($packaging_ids) {
        return DB::table('packaging')
                ->select('name', 'size')
                ->whereIn('id', $packaging_ids)->get();
    }

    public function readClosures($closures_ids) {
        return DB::table('closures')
                ->select('name', 'size')
                ->whereIn('id', $closures_ids)->get();
    }


    public function create()
    {
        $categories = Category::all();
        $packaging = Packaging::all();
        $sizes = Size::all();
        $variations = Variation::all();
        $closures = Closures::all();
        return view('admin.products.create', compact('categories', 'packaging', 'sizes', 'variations', 'closures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($id)
    {
        $product_images = DB::table('product_images')->where('id', $id);
        $data = $product_images->first();
        \File::delete('images/'.$data->image);
        if ($product_images->delete()) {
            return 'success';
        }
        return 'fail';
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
            'sku' => 'required|unique:products',
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
       // return $request->all();
        Product::create($request->all());
        
        if ($images) {
            foreach ($images as $key => $data) {
                DB::table('product_images')
                ->insert([ 
                    'sku' => $request['sku'],
                    'image' => $data
                ]);
            }
        }

        if ($request->packaging) {
            foreach ($request->packaging as $data) {
                DB::table('product_packaging')
                ->insert([ 
                    'sku' => $request['sku'],
                    'packaging_id' => $data
                ]);
            }
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
        ->with('success', 'Product was created.'); 
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
    public function edit(Product $product, ProductPrice $p)
    {
        $categories = Category::all();
        $packaging = Packaging::all();
        $sizes = Size::all();
        $variations = Variation::all();
        $subcategories = Subcategory::all();
        $closures = Closures::all();
        
        $selected_packaging_arr = $product->packaging;
        $selected_closures_arr = $product->closures;

        $images = DB::table('product_images')->where('sku',$product->id)->get();
        $volumes = $p->readVolumes($product->sku);

        return view('admin.products.edit', 
        compact('product', 'categories', 'subcategories', 'selected_packaging_arr','selected_closures_arr', 'packaging', 'closures', 'sizes', 'variations', 'images', 'volumes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
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

        $product->update($request->all());

        foreach ($images as $key => $data) {
            DB::table('product_images')
            ->insert([ 
                'sku' => $product->id,
                'image' => $data
            ]);
        }

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

        return redirect()->back()
        ->with('success', 'Product was updated.'); 
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
    public function archive($id)
    {
        //Product::where('id', $id)->update(['status' => 0]);
        Product::where('id', $id)->delete();
        return response()->json([
            'status' =>  'success',
            'message' => 'Data was archived.'
        ], 200);
    }
}
