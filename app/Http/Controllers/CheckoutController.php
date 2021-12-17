<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Voucher;
use Auth;
use Cache;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->readCart();
        return view('checkout', compact('cart'));
    }

    public function readDefaultAddress() {
        return UserAddress::where('user_id', Auth::id())
            ->where('is_active', 1)
            ->first();
    }

    public function validateVoucher() {
        if (isset(request()->voucher_code)) {
            $voucher = Voucher::where('voucher_code', request()->voucher_code)->first();
            if (isset($voucher) && $voucher) {
                return $voucher->discount;
            }
            else {
                return 'invalid';
            }
        }
    }

    public function readCourier() {
        if (Cache::get('courier-cache')) {
            $data = Cache::get('courier-cache');
            return $data;
        }else {
            $courier = Courier::where('status', 1)->get();
            Cache::put('courier-cache', $courier);
            $data = $courier;
            return $data;
        }
    }

    public function readCart() {
        return Cart::where('user_id', Auth::id())
                    ->where('is_checked', 1)
                    ->select( 'P.*', 'P.name as name', 'cart.id as cart_id', 'cart.amount', 'cart.qty', 'cart.sku as sku',
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
}
