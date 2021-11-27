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

    public function subcategoryProduct($id)
    {
        $p = new Product;
        $categories = Category::all();
        return view('shop-subcategory', compact('categories'));
    }

    public function readAllProduct()
    {
        $p = new Product;
        if (Cache::get('products-cache')) {
            $data = Cache::get('products-cache');
        }else {    
            Cache::put('products-cache', $p->readAllProduct());
            $data = $p->readAllProduct();
        }
        return $data;
    }

    public function readAllPackaging()
    {
        $p = new Packaging;
        if (Cache::get('packaging-cache')) {
            $data = Cache::get('packaging-cache');
        }else {
            Cache::put('packaging-cache', $p->readAllPackaging());
            $data = $p->readAllPackaging();
        }
        return  $data;
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

    public function readCategoryID($subcategory_id) {
        return Subcategory::where('id', $subcategory_id)->value('category_id');
    }

    public function readImages($sku) {
        return DB::table('product_images')->select('id', 'image')->where('sku',$sku)->get();
    }


    public function readOneProduct($sku, $category_name)
    {
        $product = Product::where('sku', $sku)->first(); 

        $c = new Category;
        $s = new Subcategory;

        $category_id = $c->getCategoryIDByName($category_name);
        $subcategories = $s->readSubcategoryByCategory($category_id);

        if (isset($product)) {
            $p = new ProductPrice;
            $categories = Category::all();
            $packaging = Packaging::all();
            $sizes = Size::all();
            $variation = Product::where('variation_code', $product->variation_code)
                        ->select('products.sku','V.name as variation')
                        ->leftJoin('variations as V', 'V.id', '=', 'products.variation_id')
                        ->get();
            return $variation;
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
                        'selected_image',
                        'category_name',
                        'category_id'
                    ));
        }
        else {
            abort(404);
        }
    }

    public function readProductInfoAjax($sku, $category_name)
    {
        $product = Product::where('sku', $sku)->first(); 
        if (isset($product)) {
            $p = new ProductPrice;
            
            return $product;
            
        }
        else {
            abort(404);
        }
    }
}
