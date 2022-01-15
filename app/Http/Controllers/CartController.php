<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use DB;
use App\Models\Category;
use App\Models\Packaging;
use App\Models\ProductPrice;
use Auth;

class CartController extends Controller
{
    public function index() {
        $categories = Category::all();
        $cart = $this->readCart();
        return view('cart', compact('categories', 'cart'));
    }

    

    public function readOnePriceBySKUAndVolume($sku, $volume) {
        $p = new ProductPrice;
        return  $p->readOnePriceBySKUAndVolume($sku, $volume);
    }

    public function readPackagingPriceBySKUAndVolume($id, $volume) {
        $p = new ProductPrice;
        $sku = DB::table('products')->where('id', $id)->value('sku');
        return  $p->readOnePriceBySKUAndVolume($sku, $volume);
    }

    public function addToCart() {

       if (Auth::check()) {
            $product = new Product;
            $user_id = Auth::id();
            $sku = request()->sku;
            $price = 0;

            $order_type = request()->order_type;
            $retail_price = $product->readPriceBySKU($sku);
            $price = $retail_price;

            $packaging_price = 0;
            $cap_price = 0;

            $packaging_id = $this->readDefaultPackaging($sku);
            $default_packaging_price = $product->readPackagingPriceByID($packaging_id);

            $packaging_price = $default_packaging_price;

            $cap_id = $this->readDefaultCap($sku);
            $default_cap_price = $product->readPackagingPriceByID($cap_id);

            $cap_price = $default_cap_price;

            $qty = 1;
            $total_amount = $retail_price;
    
            if (isset(request()->packaging_sku)) {
                $packaging_id = request()->packaging_sku;
                $packaging_price = $this->readPackagingPriceBySKUAndVolume($packaging_id, request()->volume);
            }
            if (isset(request()->closure_sku)) {
                $cap_id = request()->closure_sku;
                $cap_price = $this->readPackagingPriceBySKUAndVolume($cap_id, request()->volume);
            }
            if (isset(request()->volume) && request()->volume) {

                $qty = request()->volume;

                if ($order_type == 1) {
                    $price = $this->readOnePriceBySKUAndVolume($sku, request()->volume);
                }
               
                $main_product_price = $price;

            //    $selected_packaging_price = $packaging_price;
            //    $selected_cap_price = $cap_price;

            //    if ($product->isPackagingPriceIncluded($sku)) {
            //        $packaging_price = $default_packaging_price - $packaging_price;
            //    }
            //    if ($product->isCapPriceIncluded($sku)) {
            //        $cap_price = $default_cap_price - $cap_price;
            //    }

                $over_all_total = $main_product_price + $packaging_price + $cap_price;
                $total_amount = (float)$over_all_total * $qty;
            }
        
            
            if ($this->readProductQty($sku) < $qty) {
                return response()->json([
                    'status' =>  'success',
                    'data' => 'not enough stock'
                ], 200);
            } 
            else {
                if ($this->isRebrandingProductExists($sku, $packaging_id, $cap_id, $user_id, $qty, $order_type)) {
                    return response()->json([
                        'status' =>  'success',
                        'data' => 'rebranding_exists'
                    ], 200);
                }
                else {
                    if ($this->isProductExists($sku, $packaging_id, $cap_id, $user_id, $order_type) == true) {

                        if ($order_type == 1) {
    
                        }
    
                        Cart::where([
                            ['user_id', $user_id],
                            ['sku', $sku]
                        ])
                            ->update([
                                'amount' => DB::raw('amount + '. $total_amount .''),
                                'qty' => DB::raw('qty + '. $qty)
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
                            'packaging_sku' => $packaging_id,
                            'cap_sku' => $cap_id,
                            'qty' => $qty,
                            'amount' => $total_amount,
                            'order_type' => $order_type
                        ]);
                    }
                }
            }
        
      
       }
       else {
           return response()->json(['status' => 200, 'message' => 'unauthorized']);
       }
    }

    public function isProductExists($sku, $packaging_id, $cap_id, $user_id, $order_type){
        $cart = Cart::where([
                ['user_id', $user_id],
                ['sku', $sku],
                ['packaging_sku', $packaging_id],
                ['cap_sku', $cap_id],
                ['order_type', $order_type]
            ])->get();

        return $cart->count() > 0 ? true : false;
    }

    public function isRebrandingProductExists($sku, $packaging_id, $cap_id, $user_id, $qty, $order_type){
        $cart = Cart::where([
                ['user_id', $user_id],
                ['sku', $sku],
                ['packaging_sku', $packaging_id],
                ['cap_sku', $cap_id],
                ['qty', $qty],
                ['order_type', $order_type]
            ])->get();

        return $cart->count() > 0 ? true : false;
    }

    public function readProductQty($sku){
        return Product::where('sku', $sku)->value('qty');
    }


    public function readCart() {
        return Cart::where('user_id', Auth::id())
                    ->select( 'P.*', 'P.name as name', 'P.qty as stock', 'cart.id as cart_id', 'cart.amount', 'cart.qty', 'cart.sku as sku', 'cart.is_checked',
                    'PG.name as packaging', 'C.name as closure', 'cart.packaging_sku', 'cart.cap_sku',
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

    
    public function removeOneItem($id) {

        Cart::where('id', $id)->delete();
        
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
