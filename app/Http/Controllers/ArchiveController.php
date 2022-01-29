<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use Utils;

class ArchiveController extends Controller
{
    private $page = "Archive";

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
    public function index(Product $product) {
        $per_page = 10;
        $product = $product->readArchiveProduct($per_page);
        return view('admin.archive.index', compact('product'));
    }

    public function restore($id) {
     
        Product::where('id', $id)->update(['status'=>1]);

        return response()->json([
            'status' =>  'success',
            'message' => 'query executed'
        ], 200);
    }

    public function archive($id) {
     
        Product::where('id', $id)->update(['status'=>0]);

        return response()->json([
            'status' =>  'success',
            'message' => 'query executed'
        ], 200);
    }
}
