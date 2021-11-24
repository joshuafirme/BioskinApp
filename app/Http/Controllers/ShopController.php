<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Carousel;
use App\Models\Product;
class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $carousel = Carousel::orderBy('order')->get();
        return view('shop', compact('categories', 'carousel'));
    }

    public function readProductByCategory()
    {
        $categories = Category::all();
        $p = new Product;
        $products = $p->readAllProduct();
        
        return view('shop-category', compact('categories', 'products'));
    }
}
