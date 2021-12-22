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
        $_ipaddress = $_SERVER['REMOTE_ADDR'];
        $_noturl = "http://127.0.0.1:8000/paynamics"; 
        $_resurl = "http://127.0.0.1:8000/paynamics"; 
        $_cancelurl = "http://localhost/aspr/cancel/"; 
        $_fname = "Joshua"; 
        $_mname = "C"; 
        $_lname = "Firme"; 
        $_addr1 = "Nasugbu Batangas"; 
        $_addr2 = "Nasugbu Batangas";
        $_city = "Batangas"; 
        $_state = "MM"; 
        $_country = "PH"; 
        $_zip = "2314"; 
        $_sec3d = "enabled";  
        $_email = "technical@paynamics.net";
        $_phone = "3308772"; 
        $_mobile = "09178134828"; 
        $_clientip = $_SERVER['REMOTE_ADDR'];

        $expiry_limit = date('yyyy-MMddTHH:mm');
        $trxtype = 'authorized';
        
        $_amount = 200.00; 
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
                $_phone . 
                $_clientip . 
                $_amount . 
                $_currency . 
                $_sec3d. 
                $expiry_limit.
                $trxtype.
                $mkey;
                
                
        $_sign = hash("sha512", $forSign);
        $strxml = '
        <?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns:xsd="http://www.w3.org/2001/XMLSchema"
        xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
        <saleResponse xmlns="http://test.payserv.net/">
        <saleResult>
        <application>
        <merchantid>'.$_mid.'</merchantid>
        <merchantkey>'.$mkey.'</merchantkey>
        <request_id>'.$_requestid.'</request_id>
        <response_id>'.$_responseid.'</response_id>
        <timestamp></timestamp>
        <rebill_id> </rebill_id>
        <signature>'.$_sign.'</signature>
        </application>
        <responseStatus>
        <response_code> </response_code>
        <response_message> </response_message>
        <response_advise> </response_advise>
        </responseStatus>
        </saleResult>
        </saleResponse>
        </soap:Body>
        </soap:Envelope>
        ';
        
       
        $b64string =  base64_encode($strxml);
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'https://testpti.payserv.net/webpayment/defaultv3/ResponsePage.aspx', [
            'body' => $b64string,
            'headers' => [
                "Content-type: text/xml;charset=\"utf-8\"",
                "Accept: text/xml",
            ],
          ]);
          
          return  $response->getBody();
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
