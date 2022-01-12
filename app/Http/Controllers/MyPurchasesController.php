<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use DB;
use Utils;

class MyPurchasesController extends Controller
{
    public function index(Product $product)
    {           
        return view('my-purchases', compact('product'));
    }

    public function readOne($order_id)
    {
        $product = new Product;
        $o = new Order;
        $order_items = $o->readMyOrders($order_id);
        
        if (count($order_items) == 0) {
            abort(404);
        }
        $address = $o->readShippingAddress($order_id);
     
        return view('my-purchase', compact('order_items', 'order_id', 'address', 'product'));
    }
}
