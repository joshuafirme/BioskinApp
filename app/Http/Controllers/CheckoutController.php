<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Courier;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderDetail;
use App\Models\Paynamics;
use App\Models\ProductPrice;
use Auth;
use Cache;
use DB;

class CheckoutController extends Controller
{
    public function index(Product $product)
    { 
        $ip = $this->getIp();
        $user = Auth::user();
        $address = $this->readDefaultAddress();
        $product_price = new ProductPrice;
        $cart = $this->readCartChecked();
        return view('checkout', compact('cart', 'user', 'address', 'ip', 'product', 'product_price'));
    }

    public function paynamicsPayment() {
        $ip = $this->getIp();
        $user = Auth::user();
        $product = new Product;
        $od = new OrderDetail;
        
        $address = $this->readDefaultAddress();
        $checkout_items = $this->readCartChecked();
        $voucher_code = request()->voucher_code;

        $total = $this->cartCheckedTotalAmount();
        $discount = $this->getDiscount($voucher_code);
   
        if (isset(request()->pay_now) && request()->pay_now == 'true') {
            $order_id = request()->order_id;
            session()->put('order_id', $order_id);
            $order = new Order;
            $address = $od->readOrderDetails($order_id);

            $checkout_items = $order->readMyOrders($order_id);
            $total = $order->readTotalAmount($order_id);
        //    $discount = $od->discount == null ? 0 : $od->discount;
        }

        else if (isset(request()->buy_now) && request()->buy_now == 'true') {
            $sku = request()->sku;
            $checkout_items = $product->readProductBySKU($sku);
            $total = $product->readPriceBySKU($sku);
        }

   
        $total = $total - $discount;

        $_mid = "000000201221F7E57B0B"; 
        $_requestid = substr(uniqid(), 0, 13);
        $_ipaddress = $ip;
        $_noturl = route('paynamicsNotification'); 
        $_resurl = route('paynamicsNotification');
        $_cancelurl = route('paynamicsNotification'); 
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
        $_mobile = $address->phone_no; 
        $_clientip = $_SERVER['REMOTE_ADDR'];
        $_amount = number_format((float)$total, 2, '.', '') ;
        $_currency = "PHP"; 
        $_sec3d = "try3d";  
        $_mkey = "35440C9612BDA6F568EAA9A5BA7A6BEA";
      
        $for_sign = $_mid . $_requestid . $_ipaddress . $_noturl . $_resurl . $_fname . $_lname . $_mname . $_addr1 . $_addr2 . $_city . $_state . $_country . 
        $_zip . $_email . $_phone . $_clientip . $_amount . $_currency . $_sec3d . $_mkey;
         
        $_sign = hash("sha512", $for_sign);

        $strxml = "";
        $strxml .= "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
        $strxml .= "<Request>";
            $strxml .= "<orders>";
                $strxml .= "<items>";
                    $debug_total = [];
                    foreach ($checkout_items as $key => $item) {
                        // if rebranding
                        if ((isset($item->order_type) && $item->order_type == 1) || (isset($item->rebranding) && $item->rebranding == 1)) {
                            $price_by_volume = $this->readOnePriceBySKUAndVolume($item->sku, $item->qty);
                            if ($price_by_volume) {
                                $item->price = $price_by_volume;
                            }
                       
                            $packaging_price = $this->readPackagingPriceBySKUAndVolume($item->packaging_sku, $item->qty);
                            $cap_price = $this->readPackagingPriceBySKUAndVolume($item->cap_sku, $item->qty);
                            $item->price = $item->price + $packaging_price + $cap_price;
                        }
                        if (request()->buy_now == 'true') {
                            $item->qty = 1;
                        }
                        array_push($debug_total, $item->price);
                        if ($discount > 0) {
                            $item->price = $item->price - (((float)$discount / count($checkout_items)) / $item->qty);
                        } 
                        $strxml .= "<Items>";
                            $strxml .= "<itemname>".$item->name ."</itemname>";
                            $strxml .= "<quantity>".$item->qty ."</quantity>";
                            $strxml .= "<amount>".number_format((float)$item->price, 2, '.', '') ."</amount>";
                        $strxml .= "</Items>";
                    } 
                    //return $debug_total;
                    /*if ($discount > 0) {
                        $strxml .= "<Items>";
                            $strxml .= "<itemname>Discounted each item.</itemname>";
                            $strxml .= "<quantity>0</quantity>";
                            $strxml .= "<amount>".$discount ."</amount>";
                        $strxml .= "</Items>";
                    }*/
                   
                $strxml .= "</items>";
            $strxml .= "</orders>";
            $strxml .= "<mid>" . $_mid . "</mid>";
            $strxml .= "<request_id>" . $_requestid . "</request_id>";
            $strxml .= "<ip_address>" . $_ipaddress . "</ip_address>";
            $strxml .= "<notification_url>" . $_noturl . "</notification_url>";
            $strxml .= "<response_url>" . $_resurl . "</response_url>";
            $strxml .= "<cancel_url>" . $_cancelurl . "</cancel_url>";
            $strxml .= "<mtac_url>".url('/terms-and-conditions')."</mtac_url>"; // pls set this to the url where your terms and conditions are hosted
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

            return $this->getPaynamicsForm($b64string);
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

    public function paynamicsNotification() { 
        if (!empty(request()->responseid) && !empty(request()->requestid)) {
            $request_id = base64_decode(request()->requestid);
            $response_id = base64_decode(request()->responseid);

            $result = $this->getPaymentStatus($request_id, $response_id);
          //  return json_encode($result);

            if (isset($result->queryResult->txns->ServiceResponse)) {
                $response_code = $result->queryResult->txns->ServiceResponse->responseStatus->response_code;
                $response_message = $result->queryResult->txns->ServiceResponse->responseStatus->response_message;
                $response_advise = $result->queryResult->txns->ServiceResponse->responseStatus->response_advise;
                $processor_response_id = $result->queryResult->txns->ServiceResponse->responseStatus->processor_response_id;
              }
              else {
                $response_code = $result->queryResult->responseStatus->response_code;
                $response_message = $result->queryResult->responseStatus->response_message;
                $response_advise = $result->queryResult->responseStatus->response_advise;
                $processor_response_id = $result->queryResult->responseStatus->processor_response_id;
              }
  
            switch ($response_code) {
                case 'GR001':
                case 'GR002':
                    $status = 1;
                    $this->updatePaymentDetails($response_message, $response_advise, $processor_response_id,$status);
                    return view('checkout-success', compact('response_message', 'response_advise', 'processor_response_id'));
                    break;
                case 'GR053':
                    $status = 0;
                    $response_message = "Transaction cancelled";
                    $response_advise = "";
                    $this->updatePaymentDetails($response_message, $response_advise, $processor_response_id,$status);
                    return view('checkout-success', compact('response_message', 'response_advise', 'processor_response_id'));
                    break;
                case 'GR033':
                    $status = 0;
                    $this->updatePaymentDetails($response_message, $response_advise, $processor_response_id,$status);
                    return view('checkout-success', compact('response_message', 'response_advise', 'processor_response_id'));
                    break;
                default:
                    return view('checkout-success', compact('response_message', 'response_advise', 'processor_response_id'))->with('danger', '');
                    break;
            }
        }
    }

    public function updatePaymentDetails($response_message, $response_advise, $processor_response_id,$status) {
        OrderDetail::where('order_id', session()->get('order_id'))
        ->update([
            'request_id' => request()->responseid,
            'response_id' => request()->requestid,
            'response_message' => $response_message,
            'status' => $status
        ]);

        if ($status == 0) {

            $orders = Order::where('order_id', session()->get('order_id'))->get();

            foreach ($orders as $item) {
                $this->addToInventory($item->sku, $item->qty);
            }
        }
        $this->removeCartChecked();
    }

    public function addToInventory($sku, $qty){
        
        Product::where('sku', $sku)
            ->update([
                'qty' => DB::raw('qty + '. $qty .'')
            ]);
    }

    public function getPaymentStatus($request_id, $response_id) {
        $paynamics = new Paynamics;
        return $paynamics->getPaymentStatus($request_id, $response_id);
    }

    public function getPaynamicsForm($b64string) {
        return '<form action="https://testpti.payserv.net/webpayment/Default.aspx" method="post" id="paynamics_payment_form">
            <style type="text/css">
                @import url(https://fonts.googleapis.com/css?family=Roboto);
                .Absolute-Center {
                    font-family: "Roboto", Helvetica, Arial, sans-serif;
                    width: auto;
                    top:0;
                    bottom: 0;
                    left: 0;
                    right: 0;
                    margin: auto;
                    text-align: center;
                    font-size: 14px;
                }
            </style>
            <div class="Absolute-Center card">
                <h3 class="m-3"><i class="fas fa-spinner fa-pulse"></i> Please wait while you are being redirected to Paynamics payment page.</h3>
            </div>
            <input type="hidden" name="paymentrequest" id="paymentrequest" value="'.$b64string.'" style="width:800px; padding: 20px;">
            <script type="text/javascript">
                setTimeout(function (){
                    document.forms["paynamics_payment_form"].submit();
                },2000);
            </script>
        </form>';
    }

    public function placeOrder() {
  
        $items = $this->readCartChecked();
        $order_id = $this->generateOrderID();
        $user_id = Auth::id();
        $product = new Product;
        $voucher_mdl = new Voucher;
        
        $total = $this->cartCheckedTotalAmount();
       
        if (isset(request()->buy_now) && request()->buy_now == "true") {  
            $sku = request()->sku;
            $this->updateInventory($sku, 1);

            $total = $product->readPriceBySKU($sku);

            Order::create([
                'order_id' => $order_id,
                'user_id' => $user_id,
                'sku' => $sku,
                'packaging_sku' => $product->readDefaultPackagingID($sku),
                'cap_sku' => $product->readDefaultCapID($sku),
                'qty' => 1,
                'amount' => $total,
            ]);
        } 
        else {
            foreach ($items as $data) {
                Order::create([
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                    'sku' => $data->sku,
                    'packaging_sku' => $data->packaging_sku,
                    'cap_sku' => $data->cap_sku,
                    'qty' => $data->qty,
                    'amount' => $data->amount,
                    'rebranding' => $data->order_type,
                ]);
    
                $this->updateInventory($data->sku, $data->qty);
            }
        }
        
   
        $voucher = Voucher::where('voucher_code', request()->voucher_code)->first();
     
        if (isset(request()->address_id) && isset(request()->courier_id) && isset(request()->opt_payment_method)) {

            //if voucher valid
            $voucher_code = "";
            if (isset($voucher) && $voucher) {
                
                $voucher_code = request()->voucher_code;

                $voucher_result = $voucher_mdl->initVoucher($voucher_code, $total);

                if ($voucher_result == "minimum_amount_exceeded") {
                    return response()->json([
                        'status' => 'minimum_amount_exceeded',
                    ]);
                }
                else if ($voucher_result == "voucher_limit_exceeded") {
                    return response()->json([
                        'status' => 'voucher_limit_exceeded',
                    ]);
                }
                else if ($voucher_result == "not_valid") {
                    return response()->json([
                        'status' => 'not_valid',
                    ]);
                }
                
            }


           $pmethod = request()->opt_payment_method;
           $expiry_date = "";
           $status = 0;

            if ($pmethod == 'COD') {
                $status = 1;
                $this->removeCartChecked();
            }
            else {
             //   $expiry_date = date('Y-m-d H:m:s', strtotime(date('Y-m-d H:m:s').' + 1 days'));
            }

            OrderDetail::create([
                'order_id' => $order_id,
                'address_id' => request()->address_id,
                'courier_id' => request()->courier_id,
                'voucher_code' => $voucher_code,
                'payment_method' => $pmethod,
                'shipping_fee_mop' => 1,
                'expiry_date' => $expiry_date,
                'status' => $status,
            ]);
        }


        Cache::forget('products-cache');
        Cache::forget('packaging-cache');

        session()->put('order_id', $order_id);
        return $order_id;
    }


    public function updateInventory($sku, $qty){
        
        Product::where('sku', $sku)
            ->update([
                'qty' => DB::raw('qty - '. $qty .'')
            ]);
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
        $couriers = Cache::get('courier-cache');
        if (!$couriers) { 
            $couriers = Courier::where('status', 1)->get();
            Cache::put('courier-cache', $couriers);
        }
        return $couriers;
    }

    public function readCartChecked() {
        return Cart::where('user_id', Auth::id())
                    ->where('is_checked', 1)
                    ->select( 'P.*', 'P.name as name', 'P.qty as stock', 'P.price', 'cart.id as cart_id', 'cart.amount', 'cart.qty', 'cart.sku as sku',
                    'PG.name as packaging', 'C.name as closure', 'cart.packaging_sku', 'cart.cap_sku', 'cart.order_type',
                    'V.name as variation', 'category.name as category')
                    ->leftJoin('products as P', 'P.sku', '=', 'cart.sku')
                    ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
                    ->leftJoin('products as PG', 'PG.sku', '=', 'cart.packaging_sku')
                    ->leftJoin('products as C', 'C.sku', '=', 'cart.cap_sku')
                    ->leftJoin('category', 'category.id', '=', 'P.category_id')
                   // ->where('P.qty','>', 0)
                    ->orderBy('cart.id', 'desc')
                    ->get();
    }

    public function cartCheckedTotalAmount() {
        return Cart::where('user_id', Auth::id())
                    ->where('is_checked', 1)
                    ->leftJoin('products as P', 'P.sku', '=', 'cart.sku')
                 //   ->where('P.qty','>', '0')
                    ->sum('amount');
    }

    public function validateQty() {
        $items = $this->readCartChecked();
        $out_of_stock_str = "";
        foreach ($items as $data) {
            $product = Product::select('name', 'qty')->where('sku', $data->sku)->first();
            $qty_order = $data->qty;

            if ($product->qty < $qty_order) {
                $out_of_stock_str .= $product->name . " <br>  ";
            }
        }
        return $out_of_stock_str;
    }

    public function getDiscount($voucher_code) {
        $discount = OrderDetail::where('order_details.voucher_code', $voucher_code)
                    ->leftJoin('voucher as v', 'v.voucher_code', '=', 'order_details.voucher_code')
                    ->value('discount');
        return $discount ? $discount : 0;
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
