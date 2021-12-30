<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';
    
    protected $fillable = [
        'user_id',
        'name',
        'phone_no',
        'region',
        'province',
        'municipality',
        'brgy',
        'detailed_loc',
        'notes',
        'is_active'
    ];
}
