<?php

namespace App\Models;

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
}
