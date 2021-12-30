<?php

namespace App\Models;

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
        'shipping_fee_mop',
        'status'
    ];
   
}
