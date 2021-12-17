<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use DB;
use App\Models\Category;
use App\Models\Packaging;
use Auth;

class CartController extends Controller
{
    public function index() {
        $categories = Category::all();
        $cart = $this->readCart();
        return view('cart', compact('categories', 'cart'));
    }

    public function addToCart() {

       if (Auth::check()) {
            $user_id = Auth::id();
            $sku = request()->sku;
            $order_type = request()->order_type;
            $retail_price = request()->retail_price;

            $packaging_sku = $this->readDefaultPackaging($sku);
            $cap_sku = $this->readDefaultCap($sku);

            $qty = 1;
            $total_amount = $retail_price;

            if (isset(request()->packaging_sku)) {
                $packaging_sku = request()->packaging_sku;
            }
            if (isset(request()->closure_sku)) {
                $cap_sku = request()->closure_sku;
            }
            if (isset(request()->volume)) {
                $qty = request()->volume;
            }
            if (isset(request()->total_amount)) {
                $total_amount = request()->total_amount;
            }
            

            if ($this->isProductExists($sku, $user_id, $order_type) == true) {
                Cart::where([
                    ['user_id', $user_id],
                    ['sku', $sku]
                ])
                    ->update([
                        'amount' => DB::raw('amount + '. $retail_price .''),
                        'qty' => DB::raw('qty + '. 1)
                    ]);
                    
                    return response()->json([
                        'status' =>  'success',
                        'data' => 'update existing product'
                    ], 200);
            }
            else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'sku' => $sku,
                    'packaging_sku' => $packaging_sku,
                    'cap_sku' => $cap_sku,
                    'qty' => $qty,
                    'amount' => $total_amount,
                    'order_type' => $order_type
                ]);
            }
      
       }
       else {
           return response()->json(['status' => 200, 'message' => 'unauthorized']);
       }
    }

    public function isProductExists($sku, $user_id, $order_type){
        $cart = Cart::where([
                ['user_id', $user_id],
                ['sku', $sku],
                ['order_type', $order_type]
            ])->get();

        return $cart->count() > 0 ? true : false;
    }

    public function readCart() {
        return Cart::where('user_id', Auth::id())
                    ->select( 'P.*', 'P.name as name', 'cart.id as cart_id', 'cart.amount', 'cart.qty', 'cart.sku as sku', 'cart.is_checked',
                    'PG.name as packaging', 'C.name as closure', 
                    'V.name as variation', 'category.name as category')
                    ->leftJoin('products as P', 'P.sku', '=', 'cart.sku')
                    ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
                    ->leftJoin('products as PG', 'PG.sku', '=', 'cart.packaging_sku')
                    ->leftJoin('products as C', 'C.sku', '=', 'cart.cap_sku')
                    ->leftJoin('category', 'category.id', '=', 'P.category_id')
                    ->orderBy('cart.id', 'desc')
                    ->get();
    }

    public function checkItem($id) {
        Cart::where('id', $id)->update([ 'is_checked' => request()->check_value ]);
    }

    public function readPackagingName($sku) {
        return Packaging::where('sku', $sku)->value('name');
    }

    public function cartCount() {
        return Cart::where('user_id', Auth::id())->count();
    }

    public function removeItem($ids) {

        $ids_arr =  explode(',', $ids);
        Cart::whereIn('id', $ids_arr)->delete();
        
        return 'deleted';
    }

    public function readDefaultPackaging($sku) {

        $packaging = Product::where('sku', $sku)->value('packaging');
        if ($packaging) {
            return $packaging[0];
        }
        else {
            return '0';
        }
    }

    public function readDefaultCap($sku) {
        
        $closure = Product::where('sku', $sku)->value('closures');
        if ($closure) {
            return $closure[0];
        }
        else {
            return '0';
        }
    }
}
