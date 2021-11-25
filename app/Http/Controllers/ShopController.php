<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Carousel;
use App\Models\Product;
use App\Models\Packaging;
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

    public function readOneProduct($sku) {
        return DB::table('product_images')->where('sku',$sku)->value('image');
    }
}
