<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;

class ManageOrderController extends Controller
{
    public function index()
    {
        return view('admin.manage-order.index');
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
        else if (request()->object == "received") {
            $status = 4;
        }
        else if (request()->object == "completed") {
            $status = 5;
        }
        else if (request()->object == "cancelled") {
            $status = 6;
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
        
        if (request()->status == 2) { 
           // $orders = $this->readOneOrder($order_id);
           // $this->recordSale($orders);
        }

        OrderDetail::where('order_id', $order_id)->update([
            'status' => request()->status
        ]);
        
        return response()->json([
            'status' => 'success',
            'message' => 'order changed status success',
            'req_params' =>request()->status
        ]);
    }

    public function readShippingAddress($order_id) {
        $o = new Order;
        $data = $o->readShippingAddress($order_id);
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
