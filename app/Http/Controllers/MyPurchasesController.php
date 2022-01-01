<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use DB;

class MyPurchasesController extends Controller
{
    public function index()
    {
        $my_orders = Order::select('orders.order_id')
                ->where('user_id', Auth::id())
                ->orderBy('orders.created_at', 'desc')
                ->distinct('order_id')
                ->paginate(3);

                
        return view('my-purchases', compact('my_orders'));
    }

    public function readOne($order_id)
    {
        $o = new Order;
        $order_items = $o->readMyOrders($order_id);
   
        $address = $o->readShippingAddress($order_id);
     
        return view('my-purchase', compact('order_items', 'order_id', 'address'));
    }
}
