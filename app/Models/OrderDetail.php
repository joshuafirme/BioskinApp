<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';
    
    protected $fillable = [
        'order_id',
        'address_id',
        'courier_id',
        'voucher_code',
        'payment_method',
        'request_id',
        'response_id',
        'response_message',
        'expiry_date',
        'status'
    ];

    public function readOrderDetails($order_id) {
        return DB::table('order_details as OD')
            ->select('UA.*', 'C.name as courier', 'V.discount')
            ->leftJoin('user_addresses as UA', 'UA.id', '=', 'OD.address_id')
            ->leftJoin('couriers as C', 'C.id', '=', 'OD.courier_id')
            ->leftJoin('voucher as V', 'V.voucher_code', '=', 'OD.voucher_code')
            ->where('order_id', $order_id)
            ->first();
    }
   
}
