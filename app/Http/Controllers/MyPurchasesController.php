<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use DB;
use Utils;

class MyPurchasesController extends Controller
{
    public function index(Product $product)
    {           
        $order_mdl = new Order;
        return view('my-purchases', compact('product', 'order_mdl'));
    }

    public function readOne($order_id)
    {
        $product = new Product;
        $product_price = new ProductPrice;
        $o = new Order;
        $order_items = $o->readMyOrders($order_id);
        
        if (count($order_items) == 0) {
            abort(404);
        }
        $address = $o->readShippingAddress($order_id);
     
        return view('my-purchase', compact('order_items', 'order_id', 'address', 'product', 'product_price'));
    }

    public function cancelOrder($order_id)
    {
        $status = OrderDetail::where('order_id', $order_id)->value('status');

        $date_order = strtotime(request()->date_order);
        $one_hour_ago = strtotime("-1 hour");
    
        if ($date_order >= $one_hour_ago || $status == 0) {
            OrderDetail::where('order_id', $order_id)->update([
                'status' => 5,
                'cancellation_reason' => request()->cancellation_reason
            ]);


            return 'status changed to cancel';
        }
        else {
            return 'more than 1 hr';
        }
    }

}
