<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class ManageOrderController extends Controller
{
    public function index()
    {
        return view('admin.manage-order.index');
    }

    public function readOrders(Order $o)
    {
        $status = 1;
        if (request()->object == "prepared") {
            $status = 2;
        }
        else if (request()->object == "shipped") {
            $status = 3;
        }
        else if (request()->object == "completed") {
            $status = 4;
        }
        else if (request()->object == "cancelled") {
            $status = 0;
        }
        $order = $o->readOrdersByStatus($status);
        if(request()->ajax())
        { 
            return datatables()->of($order)
                ->addColumn('action', function($order)
                {
                    $button = '<a class="btn btn-sm btn-show-order" data-name="'. $order->firstname .'" data-order-no="'. $order->order_id .'" ';
                    $button .= 'data-user-id="'. $order->user_id .'" data-payment="COD" data-delivery-date="" '; 
                    $button .= 'data-phone="'. $order->phone_no .'" data-email="'. $order->email .'" style="color:#1970F1;">Show orders</a>';
                    return $button;
                })
                ->addColumn('fullname', function($u){
                   return $u->firstname ." ". $u->middlename ." ". $u->lastname;
                })
                ->addColumn('date_order', function($o){
                    return date('F d, Y h:i A', strtotime($o->date_order));
                 })
                
                ->rawColumns(['action', 'fullname'])
                ->make(true);
        }
    }

    public function readOneOrder($order_id) {
        $order = new Order;
        return $order->readOneOrder($order_id);
    }

    public function readTotalAmount($order_no) {
        return DB::table('orders')
        ->where('order_no', $order_no)
        ->sum('amount');
    }
}
