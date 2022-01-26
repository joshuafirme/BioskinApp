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
use Cache;
use Auth;
use App\Models\Closures;
use App\Models\ProductPrice;

class ProductController extends Controller
{
    private $page = "Maintenance";

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            if (Auth::check()) {
                $allowed_pages = explode(",",Auth::user()->allowed_pages);
                if (!in_array($this->page, $allowed_pages)) {
                    return redirect('/not-auth');
                }
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = new Product;
        $product = $product->readAllProduct('product');
        return view('admin.products.index');
    }

    public function deleteProductCache() {
        Cache::forget('products-cache');
        return redirect()->back()->with('success', 'Cache was deleted');
    }

    public function readAllProduct() {
        
        $product = new Product;
        $object = request()->object;

        $product = $product->readAllProduct($object);
        
        
        if(request()->ajax())
        { 
            return datatables()->of($product)
                ->addColumn('action', function($product)
                {
                    $button = ' <a class="btn btn-sm" data-id="'. $product->id .'" href="'. route(request()->object.'.edit',$product->id) .'"><i class="fa fa-edit"></i></a>';
                    $button .= ' <a class="btn btn-sm btn-archive" data-id="'. $product->id .'" data-toggle="modal" data-target="#confirmation-modal"><i class="fa fa-archive"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                  //  $button .= '<a data-id="'. $product->id .'" class="btn btn-archive-product" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-trash"></i></a>';
                    return $button;
                })
                ->addColumn('variation', function($product){ return $product->variation_id == 0 ? "None" : $product->variation; })
                ->addColumn('category', function($product){
                    $html = "";
                    $categories = $this->readCategories($product->category_id);
                    foreach ($categories as $data) {
                        $html .= '<span class="badge badge-primary m-1">'.$data->name.'</span>';
                    }
                    return $html;
                })
                ->addColumn('subcategory', function($product){
                    $html = "";
                    $sub_categories = $this->readSubCategories($product->sub_category_id);
                    foreach ($sub_categories as $data) {
                        $html .= '<span class="badge badge-primary m-1">'.$data->name.'</span>';
                    }
                    return $html;
                })
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
                        foreach ($this->readPackaging($closures_ids) as $data) {
                            $html .= '<span class="badge badge-primary m-1">'. $data->name .' '. $data->size . '</span>';
                        }
                    }
                    return $html;
                })
                ->rawColumns(['action','volumes', 'packaging', 'closures', 'category', 'subcategory'])
                ->make(true);
        }
    }

    public function readCategories($ids) {
        $ids = explode(', ', $ids);
        return DB::table('category')
                ->whereIn('id', $ids)->get('name');
    }
    public function readSubCategories($ids) {
        $ids = explode(', ', $ids);
        return DB::table('subcategory')
                ->whereIn('id', $ids)->get('name');
    }
    public function readPackaging($packaging_ids) {
        return DB::table('products')
                ->select('name', 'size')
                ->whereIn('id', $packaging_ids)->get();
    }

    public function readClosures($closures_ids) {
        return DB::table('closures')
                ->select('name', 'size')
                ->whereIn('id', $closures_ids)->get();
    }

    public function readPackagingNameByID($id) {
        $product = new Product;
        return $product->readPackagingNameByID($id);
    }


    public function create()
    {
        $categories = Category::all();
        $packaging = Product::where('category_id', 10)->get();
        $sizes = Size::all();
        $variations = Variation::all();
        $subcategories = Subcategory::all();
        return view('admin.products.create', compact('categories', 'packaging', 'sizes', 'variations', 'subcategories'));
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

        $request['category_id'] = implode(", ",$request->category_id);
        $request['sub_category_id'] = implode(", ",$request->sub_category_id);
      //  $request['packaging_price_included'] = $request->packaging_price_included == "on" ? 1 : 0;
      //  $request['closure_price_included'] = $request->closure_price_included == "on" ? 1 : 0;
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
        Cache::forget('products-cache');
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
        $packaging = Product::where('category_id', 10)->get();
        $sizes = Size::all();
        $variations = Variation::all();
        $subcategories = Subcategory::all();
        $closures = Closures::all();
        
        $selected_category_arr = explode(", ", $product->category_id);
        $selected_subcategory_arr = explode(", ", $product->sub_category_id);
        $selected_packaging_arr = $product->packaging;
        $selected_closures_arr = $product->closures;

        $images = DB::table('product_images')->where('sku',$product->sku)->get();
        $volumes = $p->readVolumes($product->sku);

        return view('admin.products.edit', 
        compact('product', 'categories', 'subcategories','selected_subcategory_arr', 'selected_category_arr', 'selected_packaging_arr','selected_closures_arr', 'packaging', 'closures', 'sizes', 'variations', 'images', 'volumes'));
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
 
        $request['category_id'] = implode(", ",$request->category_id);
        $request['sub_category_id'] = implode(", ",$request->sub_category_id);

        if (!$request->packaging) {
            $request['packaging'] = [];
        }

        if (!$request->closures) {
            $request['closures'] = [];
        }

      //  $request['packaging_price_included'] = $request->packaging_price_included == "on" ? 1 : 0;
      //  $request['closure_price_included'] = $request->closure_price_included == "on" ? 1 : 0;
        
        $product->update($request->all());

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
        Cache::forget('products-cache');
        return redirect()->back()
        ->with('success', 'Product was updated.'); 
    }

    public function uploadImages() {

        $images=array();

        if($file=request()->file){
            $folder_to_save = 'product';
            $image_name = uniqid() . "." . $file->extension();
            $file->move(public_path('images/' . $folder_to_save), $image_name);
            $image_path = $folder_to_save . "/" . $image_name;

            DB::table('product_images')
            ->insert([ 
                'sku' => request()->sku,
                'image' => $image_path
            ]);
        }

        return response()->json([
            'status' =>  'success',
            'message' => 'Uploaded was SUCCESS'
        ], 200);
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
