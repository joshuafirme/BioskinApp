<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Carousel;
use App\Models\Product;
use App\Models\Packaging;
use App\Models\Size;
use App\Models\Variation;
use App\Models\Closures;
use App\Models\ProductPrice;
use DB;
use Cache;
class ShopController extends Controller
{
    public function index(Product $p)
    {   
        $path = "/data";
        $path_file = public_path() . $path."/cache.json";

        $data = [];

        foreach ($p->readAllProduct() as $item) {
            $data = [
                'name' => $item->name,
            ];
        }
            Cache::put('products', $data);


        $categories = Category::all();
        $carousel = Carousel::orderBy('order')->get();
        return view('shop', compact('categories', 'carousel'));
    }

    public function categoryProduct($id)
    {
        $p = new Product;
        $categories = Category::all();
        return view('shop-category', compact('categories'));
    }

    public function readAllProduct()
    {
        $p = new Product;
        return $p->readAllProduct();
    }

    public function readAllPackaging()
    {
        $p = new Packaging;
        return  $p->readAllPackaging();
    }

    public function readPackagingBySubcategory($subcategory_id) {
        $p = new Packaging;
        return  $p->readPackagingBySubcategory($subcategory_id);
    }

    public function readImage($sku) {
        return DB::table('product_images')->where('sku',$sku)->value('image');
    }

    public function readAllCategory() {
        return Category::all();
    }

    public function readOneProduct($sku)
    {
        $product = Product::where('sku', $sku)->first(); 
        if (isset($product)) {
            $p = new ProductPrice;
    
            $categories = Category::all();
            $packaging = Packaging::all();
            $sizes = Size::all();
            $variation = Variation::all();
            $subcategories = Subcategory::all();
            $closures = Closures::all();
            
            $selected_category_arr = isset($product->category_id) ? explode(", ", $product->category_id) : [];
            $selected_subcategory_arr = isset($product->sub_category_id) ? explode(", ", $product->sub_category_id) : [];
            $selected_packaging_arr = isset($product->packaging) ? $product->packaging : [];
            $selected_closures_arr = isset($product->closures) ? $product->closures : [];
    
            $images = DB::table('product_images')->where('sku', $sku)->get();
            $volumes = $p->readVolumes($sku);
    
            $selected_image = $this->readImage($sku);
        
            return view('read-one-product', 
                    compact(
                        'product', 
                        'categories', 
                        'subcategories',
                        'selected_subcategory_arr', 
                        'selected_category_arr', 
                        'selected_packaging_arr',
                        'selected_closures_arr', 
                        'packaging', 
                        'closures', 
                        'sizes', 
                        'variation', 
                        'images', 
                        'volumes',
                        'selected_image'
                    ));
        }
        else {
            abort(404);
        }
    }
}
