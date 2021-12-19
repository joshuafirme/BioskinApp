<?php

namespace App\Models;
use DB;

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
        'status'
    ];

    public function readOrdersByStatus($status)
    {
        $data = DB::table($this->table . ' as O')
            ->select('O.*', 'O.created_at as date_order', 'users.*', 'OP.payment_method', 'OP.status')
            ->leftJoin('users', 'users.id', '=', 'O.user_id')
            ->leftJoin('order_payment as OP', 'OP.order_id', '=', 'O.user_id')
            ->where('O.status', $status)
            ->orderBy('O.id', 'desc')
            ->get();

        return $data->unique('order_id');
    }

    public function readOneOrder($order_no)
    {
        return DB::table($this->table . ' as O')
            ->select('O.*', 'P.name', 'P.price', 'O.qty as qty', 'O.created_at as date_order', 'users.*',
            'PG.name as packaging', 'C.name as closure','V.name as variation')
            ->leftJoin('products as P', 'P.sku', '=', 'O.sku')
            ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
            ->leftJoin('products as PG', 'PG.sku', '=', 'O.packaging_sku')
            ->leftJoin('products as C', 'C.sku', '=', 'O.cap_sku')
            ->leftJoin('users', 'users.id', '=', 'O.user_id')
            ->where('O.order_id', $order_no)
            ->get();
    }
}
