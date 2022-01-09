<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Carousel;
use Utils;

class HomePageController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $carousel = Carousel::orderBy('order')->get();
        return view('welcome', compact('categories', 'carousel'));
    }
}
