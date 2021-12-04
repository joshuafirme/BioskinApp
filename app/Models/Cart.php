<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'sku',
        'packaging_sku',
        'cap_sku',
        'qty',
        'amount',
    ];

    public function addToCart() {
        
    }
}
