<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'voucher_code',
        'discount',
        'minimum_purchase_amount',
        'status'
    ];
}
