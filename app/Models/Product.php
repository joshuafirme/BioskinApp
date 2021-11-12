<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'sku',
        'price',
        'description',
        'features',
        'directions_and_precautions',
        'ingredients',
        'category_id',
        'sub_category_id',
        'variation_id',
        'variations',
        'size_id',
        'sizes',
        'volume_id',
        'volumes',
        'packaging_id',
        'packaging',
        'cap_id',
        'caps',
        'images',

    ];

    protected $casts = [
        'variations' => 'array',
        'sizes' => 'array',
        'volumes' => 'array',
        'packaging' => 'array',
        'caps' => 'array',
        'images' => 'array',
    ];

}
