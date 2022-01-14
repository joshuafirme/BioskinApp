<?php

namespace App\Models;
use DB;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_id',
        'user_id',
        'sku',
        'packaging_sku',
        'cap_sku',
        'qty',
        'amount',
        'rebranding',
        'status'
    ];

    public function readOrdersByStatus($status)
    {
        $data = DB::table($this->table . ' as O')
            ->select('O.*', 'O.created_at as date_order', 'users.*', 'OD.payment_method', 'OD.status')
            ->leftJoin('users', 'users.id', '=', 'O.user_id')
            ->leftJoin('order_details as OD', 'OD.order_id', '=', 'O.order_id')
            ->where('OD.status', $status)
           // ->where('OD.courier_id', $status)
            ->orderBy('O.id', 'asc')
            ->get();

        return $data->unique('order_id');
    }

    public function readOrdersByOrderIDAndStatus($order_id)
    {
        return DB::table($this->table . ' as O')
        ->select('O.sku', 'P.size', 'O.order_id', 'O.amount', 'O.qty', 'P.name', 'P.price', 'V.name as variation', 
        'O.packaging_sku', 'O.cap_sku', 'OD.status')
        ->leftJoin('products as P', 'P.sku', '=', 'O.sku')
        ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
        ->leftJoin('category', 'category.id', '=', 'P.category_id')
        ->leftJoin('order_details as OD', 'OD.order_id', '=', 'O.order_id')
        ->where('O.user_id', \Auth::id())
        ->where('O.order_id', $order_id)
        ->orderBy('O.id', 'desc')
        ->get();
    }

    public function readOneOrder($order_no)
    {
        return DB::table($this->table . ' as O')
            ->select('O.*', 'P.name', 'P.price', 'P.size', 'O.qty as qty', 'O.created_at as date_order', 'users.*',
            'O.packaging_sku', 'O.cap_sku','V.name as variation')
            ->leftJoin('products as P', 'P.sku', '=', 'O.sku')
            ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
            ->leftJoin('users', 'users.id', '=', 'O.user_id')
            ->leftJoin('order_details as OD', 'OD.order_id', '=', 'O.order_id')
            ->where('O.order_id', $order_no)
            ->get();
    }

    public function countOrderByStatus($status) {
        return Order::where('user_id', Auth::id())
        ->leftJoin('order_details as OD', 'OD.order_id', '=', 'orders.order_id')
        ->distinct('orders.order_id')
        ->where('OD.status', $status)
        ->count('OD.id');
    }

    
    public function readMyOrders($order_id)
    {
        return DB::table('orders as O')
        ->select('O.sku', 'P.size', 'O.order_id', 'O.amount', 'O.qty', 'P.name', 'P.price', 'V.name as variation', 
        'O.packaging_sku', 'O.cap_sku', 'O.status', 'O.rebranding')
        ->leftJoin('products as P', 'P.sku', '=', 'O.sku')
        ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
        ->leftJoin('products as PG', 'PG.sku', '=', 'O.packaging_sku')
        ->leftJoin('products as C', 'C.sku', '=', 'O.cap_sku')
        ->leftJoin('category', 'category.id', '=', 'P.category_id')
        ->where('O.user_id', \Auth::id())
        ->where('O.order_id', $order_id)
        ->orderBy('O.id', 'desc')
        ->get();
    }

    public function readShippingAddress($order_id) {
        return DB::table('order_details as OD')
            ->select('UA.*')
            ->leftJoin('user_addresses as UA', 'UA.id', '=', 'OD.address_id')
            ->where('order_id', $order_id)
            ->first();
    }

    
    public function readTotalAmount($order_id) {
        return DB::table($this->table . ' as O')->where('order_id', $order_id)->sum('amount');
    }
 
}
