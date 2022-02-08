<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $table = 'payment_settings';

    protected $fillable = [
        'name',
        'enable_on_retail',
        'enable_on_rebrand',
    ];

   
}
