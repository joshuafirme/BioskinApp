<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'phone_no',
        'is_active'
    ];

    
}
