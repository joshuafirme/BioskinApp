<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use DB;

class MyPurchasesController extends Controller
{
    public function index()
    {           
        return view('my-purchases');
    }

    public function readOne($order_id)
    {
        $o = new Order;
        $order_items = $o->readMyOrders($order_id);
        
        if (count($order_items) == 0) {
            abort(404);
        }
        $address = $o->readShippingAddress($order_id);
     
        return view('my-purchase', compact('order_items', 'order_id', 'address'));
    }
}
