<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $table = 'order_payment';

    protected $fillable = [
        'order_id',
        'payment_method',
        'status'
    ];
}
