<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Carousel;
use App\Models\Product;
use DB;
class ShopController extends Controller
{
    public function index()
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

    public function readAllProduct()
    {
        $p = new Product;
        return $products = $p->readAllProduct();
    }

    public function readImage($sku) {
        return DB::table('product_images')->where('sku',$sku)->value('image');
    }

    public function readAllCategory() {
        return Category::all();
    }
}
