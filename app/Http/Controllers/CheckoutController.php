<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderDetail;
use Auth;
use Cache;
use DB;
use SoapClient;

class CheckoutController extends Controller
{
    public function index()
    {
       // return phpinfo();
        $ip = $this->getIp();
        $user = Auth::user();
        $address = $this->readDefaultAddress();
        $cart = $this->readCartChecked();
        return view('checkout', compact('cart', 'user', 'address', 'ip'));
    }

    public function paynamicsPayment() {
        $ip = $this->getIp();
        $user = Auth::user();
        $address = $this->readDefaultAddress();
        $cart = $this->readCartChecked();

        $total = $this->cartTotalAmount();
        
        $_mid = "000000201221F7E57B0B"; 
        $_requestid = substr(uniqid(), 0, 13);
        $_ipaddress = $ip;
        $_noturl = route('paynamicsNotification'); 
        $_resurl = route('paynamicsNotification'); 
        $_cancelurl = "http://127.0.0.1:8000/checkout"; 
        $_fname = $user->firstname; 
        $_mname = $user->middlename; 
        $_lname = $user->lastname; 
        $_addr1 = $address->province ." ".$address->municipality." ".$address->brgy ." ".$address->detailed_loc; 
        $_addr2 = "";
        $_city = $address->municipality; 
        $_state = ""; 
        $_country = "PH"; 
        $_zip = ""; 
        $_email = $user->email;
        $_phone = ""; 
        $_mobile = $user->phone_no; 
        $_clientip = $_SERVER['REMOTE_ADDR'];
        $_amount = number_format((float)$total, 2, '.', '');
        $_currency = "PHP"; 
        $_sec3d = "try3d";  
        $_mkey = "35440C9612BDA6F568EAA9A5BA7A6BEA";
      
        $for_sign = $_mid . 
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
                $_sec3d . 
                $_mkey;
         
        $_sign = hash("sha512", $for_sign);

        $strxml = "";
        $strxml .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
        $strxml .= "<Request>";
            $strxml .= "<orders>";
                $strxml .= "<items>";
                    // item 1
                foreach ($cart as $key => $item) {
                    $strxml .= "<Items>";
                        $strxml .= "<itemname>".$item->name ."</itemname>";
                        $strxml .= "<quantity>".$item->qty ."</quantity>";
                        $strxml .= "<amount>".$item->price ."</amount>";
                    $strxml .= "</Items>";
                }
                $strxml .= "</items>";
            $strxml .= "</orders>";
            $strxml .= "<mid>" . $_mid . "</mid>";
            $strxml .= "<request_id>" . $_requestid . "</request_id>";
            $strxml .= "<ip_address>" . $_ipaddress . "</ip_address>";
            $strxml .= "<notification_url>" . $_noturl . "</notification_url>";
            $strxml .= "<response_url>" . $_resurl . "</response_url>";
            $strxml .= "<cancel_url>" . $_cancelurl . "</cancel_url>";
            $strxml .= "<mtac_url>".$_resurl."</mtac_url>"; // pls set this to the url where your terms and conditions are hosted
            $strxml .= "<descriptor_note></descriptor_note>"; // pls set this to the descriptor of the merchant ""
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
            $strxml .= "<trxtype>authorized</trxtype>";
            $strxml .= "<email>" . $_email . "</email>";
            $strxml .= "<phone>" . $_phone . "</phone>";
            $strxml .= "<mobile>" . $_mobile . "</mobile>";
            $strxml .= "<amount >" . $_amount . "</amount>";
            $strxml .= "<currency>" . $_currency . "</currency>";
            $strxml .= "<expiry_limit></expiry_limit>"; //".date('Y-MdTH:m')."
            $strxml .= "<client_ip>" . $_clientip . "</client_ip>";
            $strxml .= "<mlogo_url>https://gmalcilk.sirv.com/c084d2e12ec5d8f32f6fa5f16b76d001.jpeg</mlogo_url>";// pls set this to the url where your logo is hosted
            $pmethod = isset(request()->pmethod) ? request()->pmethod : "";
            $strxml .= "<pmethod>". $pmethod ."</pmethod>";
            $strxml .= "<signature>". $_sign ."</signature>";
            $strxml .= "</Request>";
        
            $b64string = base64_encode($strxml);

            return '<form action="https://testpti.payserv.net/webpayment/Default.aspx" method="post" id="paynamics_payment_form">
                <style type="text/css">
                    @import url(https://fonts.googleapis.com/css?family=Roboto);
                    .Absolute-Center {
                        font-family: "Roboto", Helvetica, Arial, sans-serif;
                        width: auto;
                        height: 100px;
                        top:0;
                        bottom: 0;
                        left: 0;
                        right: 0;
                        margin: auto;
                        text-align: center;
                        font-size: 14px;
                    }
                </style>
                <div class="Absolute-Center">
                    <h3><i class="fas fa-spinner fa-pulse"></i> Please wait while you are being redirected to Paynamics payment page.</h3>
                </div>
                <input type="hidden" name="paymentrequest" id="paymentrequest" value="'.$b64string.'" style="width:800px; padding: 20px;">
                <script type="text/javascript">
                    setTimeout(function (){
                        document.forms["paynamics_payment_form"].submit();
                    },2000);
                </script>
            </form>';
    }

    public function paynamicsNotification() { 
        if (!empty($_GET["responseid"]) && !empty($_GET["requestid"])) {
            $order_id = base64_decode($_GET["requestid"]);
            $response_id = base64_decode($_GET["responseid"]);

            $mode = 'Test';

            if ($mode == 'Test') {
                $mid = "000000201221F7E57B0B";
                $mkey = "35440C9612BDA6F568EAA9A5BA7A6BEA";
                $client = new SoapClient("https://testpti.payserv.net/Paygate/ccservice.asmx?WSDL");
            } elseif ($mode == 'Live') {
                $mid = $this->_paymentMethod->getMerchantConfig('live_mid');
                $mkey = $this->_paymentMethod->getMerchantConfig('live_mkey');
                $client = new SoapClient("https://ptipaygate.paynamics.net/ccservice/ccservice.asmx?WSDL");
            }

            $request_id = '';
            $length = 8;
            $characters = '0123456789';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $request_id .= $characters[rand(0, $charactersLength - 1)];
            }

            $merchantid = $mid;
            $requestid = $request_id;
            $org_trxid = $response_id;
            $org_trxid2 = "";
            $cert = $mkey;
            $data = $merchantid . $requestid . $org_trxid . $org_trxid2;
            $data = utf8_encode($data . $cert);

            // create signature
            $sign = hash("sha512", $data);

            $params = array("merchantid" => $merchantid,
                "request_id" => $requestid,
                "org_trxid" => $org_trxid,
                "org_trxid2" => $org_trxid2,
                "signature" => $sign);

            $result = $client->query($params);    
            $response_code = $result->queryResult->txns->ServiceResponse->responseStatus->response_code;
            $response_message = $result->queryResult->txns->ServiceResponse->responseStatus->response_message;
            $response_advise = $result->queryResult->txns->ServiceResponse->responseStatus->response_advise;
            $processor_response_id = $result->queryResult->txns->ServiceResponse->responseStatus->processor_response_id;
          //  print_r(json_encode($result));
          //  return;
            switch ($response_code) {
                case 'GR001':
                case 'GR002':
                case 'GR033':
                    return view('checkout-success', compact('response_message', 'response_advise', 'processor_response_id'));
                    break;
                default:
                    return view('checkout-success', compact('response_message', 'response_advise', 'processor_response_id'))->with('danger', '');
                    break;
            }
        }
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
     
        if (isset(request()->address_id) && isset(request()->courier_id) && isset(request()->opt_payment_method)) {

            //if voucher valid
            $voucher_code = "";
            if (isset($voucher) && $voucher) {
                $voucher_code = request()->voucher_code;
            }

            OrderDetail::create([
                'order_id' => $order_id,
                'address_id' => request()->address_id,
                'courier_id' => request()->courier_id,
                'voucher_code' => $voucher_code,
                'payment_method' => request()->opt_payment_method,
                'shipping_fee_mop' => 1,
                'status' => 1,
            ]);
        }

      //  $this->removeCartChecked();
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

    public function cartTotalAmount() {
        return Cart::where('user_id', Auth::id())
                    ->where('is_checked', 1)
                    ->sum('amount');
    }

    public function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }
}
