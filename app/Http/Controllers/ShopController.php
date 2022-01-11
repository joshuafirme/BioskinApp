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
use Utils;
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
        $object = request()->object;
        
        $p = new Product;
        if (Cache::get('products-cache')) {
            $data = Cache::get('products-cache');
        }else {    
            Cache::put('products-cache', $p->readAllProduct($object));
            $data = $p->readAllProduct($object);
        }
        return $data;
    }

    public function readAllPackaging()
    {
        $object = request()->object;

        $p = new Product;
        if (Cache::get('packaging-cache')) {
            $data = Cache::get('packaging-cache');
        }else {
            Cache::put('packaging-cache', $p->readAllProduct($object));
            $data = $p->readAllProduct($object);
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
        return Utils::readCategories();
    }

    public function readCategoryID($subcategory_id) {
        return Subcategory::where('id', $subcategory_id)->value('category_id');
    }

    public function readImages($sku) {
        return DB::table('product_images')->select('id', 'image')->where('sku',$sku)->get();
    }

    public function readVolumes($sku, ProductPrice $p) {
        return  $p->readPricePerVolume($sku);
    }
    

    public function readOneProduct($sku, $category_name, Product $__product)
    {
        $product = Product::where('sku', $sku)->first(); 

        $c = new Category;
        $s = new Subcategory;

        $category_id = $c->getCategoryIDByName($category_name);
        $subcategories = $s->readSubcategoryByCategory($category_id);

        if (isset($product)) {
            $p = new ProductPrice;
            $categories = Category::all();

            $variation = $__product->readVariations($product->variation_code);
            $variation = $variation ? $variation : [];

            $images = $this->readImages($sku);

            
        }
        else {
            abort(404);
        }

        
        $volumes = $p->readVolumes($sku);
        $selected_image = $this->readImage($sku);

        return view('read-one-product', 
                compact(
                    'product', 
                    'categories', 
                    'subcategories',
                    'variation', 
                    'images', 
                    'volumes',
                    'selected_image',
                    'category_name',
                    'category_id'
                ));
    }

    public function readRebrandProduct($sku, $category_name, Product $__product)
    {
        $product = $__product::where('sku', $sku)->first(); 

        $c = new Category;
        $s = new Subcategory;

        $category_id = $c->getCategoryIDByName($category_name);
        $subcategories = $s->readSubcategoryByCategory($category_id);

        if (isset($product)) {
            $p = new ProductPrice;
            $categories = Category::all();
            $packaging = new Packaging;

            if ($product->packaging) {
                $packaging_ids = $product->packaging;
                $packagings = $packaging->readPackaging($packaging_ids);
            }
            else {
                $packagings= [];
            }
            
            if ($product->closures) {
                $closure_ids = $product->closures;
                $closures = $packaging->readPackaging($closure_ids); 
            }
            else {
                $closures = [];
            }

            $variation = $__product->readVariations($product->variation_code);
            if ($product->variation_code != "") {
                $sizes = $__product::where('variation_code', $product->variation_code)->get();
            }
            else {
                $sizes = [];
            }
    
            $images = DB::table('product_images')->where('sku', $sku)->get();

            //$volumes = $p->readVolumes($sku); 
       
            $volumes = $p->readPricePerVolume($sku);  
            $volumes = count($volumes) > 0 ? $volumes : [];
      
            $selected_image = $this->readImage($sku);
            
            return view('read-rebrand-product', 
                    compact(
                        'product', 
                        'categories', 
                        'subcategories', 
                        'packagings', 
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

    public function readPackaging($ids) {
        if (isset($ids)) {
            $ids = explode(",",$ids);
            $packaging = new Packaging;
            return $packaging->readPackaging($ids);
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
