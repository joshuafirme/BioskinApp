<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderPayment;
use Auth;
use Cache;
use DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = $this->readCartChecked();
        return view('checkout', compact('cart'));
    }

    public function paynamicsPayment() {
    
        $_mid = "000000201221F7E57B0B"; 
        $_requestid = substr(uniqid(), 0, 13);
        $_responseid = rand(9,100);
        $_ipaddress = '136.158.17.103';
        $_noturl = "http://127.0.0.1:8000/paynamics"; 
        $_resurl = "http://127.0.0.1:8000/checkout"; 
        $_cancelurl = "http://localhost/aspr/cancel/"; 
        $_fname = "Joshua"; 
        $_mname = "C"; 
        $_lname = "Firme"; 
        $_addr1 = "Nasugbu Batangas"; 
        $_addr2 = "Batangas CITY";
        $_city = "Batangas"; 
        $_state = "MM"; 
        $_country = "PH"; 
        $_zip = "2314"; 
        $_sec3d = "enabled";  
        $_email = "technical@paynamics.net";
        $_phone = "3308772"; 
        $_mobile = "09178134828"; 
        $_clientip = $_SERVER['REMOTE_ADDR'];
        $_amount = 300.00; 
        $_currency = "PHP"; 
        $mkey = "35440C9612BDA6F568EAA9A5BA7A6BEA";

        $forSign = $_mid . 
                $_requestid . 
                $_ipaddress . 
                $_noturl . 
                $_resurl .  
                $_fname . 
                $_lname . 
                $_mname . 
                $_addr1 . 
                $_addr2 . 
                $_city . 
                $_state . 
                $_country . 
                $_zip . 
                $_email . 
                $_mobile . 
                $_clientip . 
                $_amount . 
                $_currency . 
                $_sec3d . 
                $mkey;
        
        $_sign = hash("sha512", $forSign);
        
        $strxml = "";
        $strxml .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";

        $strxml .= "<Request>";
            
            $strxml .= "<orders>";
                $strxml .= "<items>";
                    // item 1
                    $strxml .= "<Items>";
                        $strxml .= "<itemname>item 1</itemname>";
                        $strxml .= "<quantity >1</quantity>";
                        $strxml .= "<amount>".$_amount ."</amount>";
                    $strxml .= "</Items>";
                $strxml .= "</items>";
            $strxml .= "</orders>";
            $strxml .= "<mid>" . $_mid . "</mid>";
            $strxml .= "<request_id>" . $_requestid . "</request_id>";
            $strxml .= "<ip_address>" . $_ipaddress . "</ip_address>";
            $strxml .= "<notification_url>" . $_noturl . "</notification_url>";
            $strxml .= "<response_url>" . $_resurl . "</response_url>";
            $strxml .= "<cancel_url>" . $_cancelurl . "</cancel_url>";
            $strxml .= "<mtac_url>".$_resurl."</mtac_url>"; // pls set this to the url where your terms and conditions are hosted
            $strxml .= "<descriptor_note>test</descriptor_note>"; // pls set this to the descriptor of the merchant ""
            $strxml .= "<fname>" . $_fname . "</fname>";
            $strxml .= "<lname>" . $_lname . "</lname>";
            $strxml .= "<mname>" . $_mname . "</mname>";
            $strxml .= "<address1>" . $_addr1 . "</address1>";
            $strxml .= "<address2>" . $_addr2 . "</address2>";
            $strxml .= "<city>" . $_city . "</city>";
            $strxml .= "<state>" . $_state . "</state>";
            $strxml .= "<country>" . $_country . "</country>";
            $strxml .= "<zip>" . $_zip . "</zip>";
            $strxml .= "<secure3d>" . $_sec3d . "</secure3d>";
            $strxml .= "<email>" . $_email . "</email>";
            $strxml .= "<phone>" . $_phone . "</phone>";
            $strxml .= "<mobile>" . $_mobile . "</mobile>";
            $strxml .= "<amount>" . $_amount . "</amount>";
            $strxml .= "<currency>" . $_currency . "</currency>";
            $strxml .= "<expiry_limit></expiry_limit>";
            $strxml .= "<trxtype>authorized</trxtype>";
            $strxml .= "<client_ip>" . $_clientip . "</client_ip>";
            $strxml .= "<mlogo_url>https://gmalcilk.sirv.com/c084d2e12ec5d8f32f6fa5f16b76d001.jpeg</mlogo_url>";// pls set this to the url where your logo is hosted
            $strxml .= "<pmethod></pmethod>";
            $strxml .= "<signature>" . $_sign . "</signature>";
        $strxml .= "</Request>";
        
    
        $b64string = base64_encode($strxml);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://testpti.payserv.net/webpayment/default.aspx', [
            'body' => $b64string,
            'headers' => [
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
            ],
          ]);
          
          return  $response;
    }

    public function placeOrder() {

        $items = $this->readCartChecked();
        $order_id = $this->generateOrderID();
        $user_id = Auth::id();

        foreach ($items as $data) {
            Order::create([
                'order_id' => $order_id,
                'user_id' => $user_id,
                'sku' => $data->sku,
                'packaging_sku' => $data->packaging_sku,
                'cap_sku' => $data->cap_sku,
                'qty' => $data->qty,
                'amount' => $data->amount,
            ]);
        }

        $voucher = Voucher::where('voucher_code', request()->voucher_code)->first();
        if (isset($voucher) && $voucher) {
            DB::table('order_voucher')->insert([
                'order_id' => $order_id,
                'voucher_code' => request()->voucher_code
            ]);
        }

        OrderPayment::create([
            'order_id' => $order_id,
            'payment_method' => 'COD',
            'status' => 1,
        ]);



        $this->removeCartChecked();
    }

    public function removeCartChecked() {
        Cart::where('is_checked', 1)
        ->where('user_id', Auth::id())
        ->delete();
    }

    public function generateOrderID() {
        return date('Ymd') . $this->generateRandomCapitalLetters(8);
    }

    public function generateRandomCapitalLetters($length = 6) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
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
        $cache_data = Cache::get('courier-cache');
        if (count($cache_data) > 0) {
            return $cache_data;
        }else {
            $courier = Courier::where('status', 1)->get();
            Cache::put('courier-cache', $courier);
            return $courier;
        }
    }

    public function readCartChecked() {
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
