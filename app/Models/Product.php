<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Product extends Model
{

    protected $fillable = [
        'sku',
        'name',
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
        'rebranding',

    ];

    protected $casts = [
        'variations' => 'array',
        'sizes' => 'array',
        'volumes' => 'array',
        'packaging' => 'array',
        'caps' => 'array',
        'images' => 'array',
    ];

    public function readAllProduct()
    {
        return DB::table('products as P')
            ->select("P.*", 'P.id as id',
                    'C.name as category',
                    'S.name as subcategory',
                    'V.name as variation',
                    'sizes.name as size',
                    'packaging.name as packaging',
                    'closures.name as closure',
                    )
            ->leftJoin('subcategory as S', 'S.id', '=', 'P.sub_category_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
            ->leftJoin('sizes', 'sizes.id', '=', 'P.size_id')
            ->leftJoin('packaging', 'packaging.id', '=', 'P.packaging_id')
            ->leftJoin('closures', 'closures.id', '=', 'P.cap_id')
            ->get();
    }

}
