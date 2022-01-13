<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Auth;
use Utils;

class ManageOrderController extends Controller
{
    public function index()
    {
        $to_pay_count = OrderDetail::distinct('order_id')->where('status', 0)->count('id');
        $processing_count = OrderDetail::distinct('order_id')->where('status', 1)->count('id');
        $otw_count = OrderDetail::distinct('order_id')->where('status', 2)->count('id');
        $to_receive_count = OrderDetail::distinct('order_id')->where('status', 3)->count('id');
        $completed_count = OrderDetail::distinct('order_id')->where('status', 4)->count('id');
        $cancelled_count = OrderDetail::distinct('order_id')->where('status', 5)->count('id');

        return view('admin.manage-order.index', compact('to_pay_count', 'processing_count', 'otw_count', 'to_receive_count', 'completed_count', 'cancelled_count'));
    }

    public function readOrders(Order $o)
    {
        $status = 1;
        if (request()->object == "to-pay") {
            $status = 0;
        }
        if (request()->object == "otw") {
            $status = 2;
        }
        else if (request()->object == "to-receive") {
            $status = 3;
        }
        else if (request()->object == "completed") {
            $status = 4;
        }
        else if (request()->object == "cancelled") {
            $status = 5;
        }
        $order = $o->readOrdersByStatus($status);
        if(request()->ajax())
        { 
            return datatables()->of($order)
                ->addColumn('action', function($order)
                {
                    $button = '<a class="btn btn-sm btn-show-order" data-name="'. $order->firstname .'" data-order-no="'. $order->order_id .'" ';
                    $button .= 'data-user-id="'. $order->user_id .'" data-payment="'.$order->payment_method.'" data-delivery-date="" '; 
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

    
    public function changeOrderStatus($order_id) {
        $remarks = "";
        if (request()->status == 1) { 
           $remarks = "We're Processing your order.";
        }
        else if (request()->status == 2) { 
            $remarks = "Processing complete.";
        }
        else if (request()->status == 3) { 
            $remarks = "Your order is out for pick up or delivery.";
        }
        else if (request()->status == 4) { 
            $remarks = "Your order has been delivered.";
        } 
        else if (request()->status == 5) { 
            $cancellation_reason = "Your order has been delivered.";
        } 
        OrderDetail::where('order_id', $order_id)->update([
            'status' => request()->status,
            'remarks' => $remarks
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'order changed status success',
            'req_params' =>request()->status
        ]);
    }

    public function readOrderDetails($order_id) {
        $o = new OrderDetail();
        $data = $o->readOrderDetails($order_id);
        return response()->json($data);
    }

    public function readOneOrder($order_id) {
        $order = new Order;
        return $order->readOneOrder($order_id);
    }

    public function readTotalAmount($order_id) {
        return DB::table('orders')
        ->where('order_no', $order_id)
        ->sum('amount');
    }
}
