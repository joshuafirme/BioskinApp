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
                    return $button;
                })
                ->addColumn('variation', function($product){ return $product->variation_id == 0 ? "None" : $product->variation; })
                ->addColumn('volumes', function($product){
                    $product->volumes = str_replace('"', '', $product->volumes);
                    $volumes = explode(",",$product->volumes);
                    $html = "";
                    foreach ($volumes as $data) {
                        $html .= '<span class="badge badge-success m-1">'.$data.'</span>';
                    }
                    return $html;
                })
                ->rawColumns(['action','volumes'])
                ->make(true);
        }
    }

    public function create()
    {
        $categories = Category::all();
        $packaging = Packaging::all();
        $sizes = Size::all();
        $variations = Variation::all();
        return view('admin.products.create', compact('categories', 'packaging', 'sizes', 'variations'));
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
            'name' => 'required:product',
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

        Product::create($request->all());
        
        $last_id = DB::getPdo()->lastInsertId();
        foreach ($images as $key => $data) {
            DB::table('product_images')
            ->insert([ 
                'product_id' => $last_id,
                'image' => $data
            ]);
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        $packaging = Packaging::all();
        $sizes = Size::all();
        $variations = Variation::all();
        $subcategories = Subcategory::all();
        $closures = Closures::all();
        $images = DB::table('product_images')->where('product_id',$product->id)->get();

        return view('admin.products.edit', compact('product', 'categories', 'subcategories', 'packaging', 'closures', 'sizes', 'variations', 'images'));
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
                'product_id' => $product->id,
                'image' => $data
            ]);
        }

        return redirect()->back()
        ->with('success', 'Product was updated.'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
