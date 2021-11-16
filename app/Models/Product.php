<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Packaging;

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
        'size',
        'volumes',
        'packaging',
        'closures',
        'rebranding',

    ];

    protected $casts = [
        'variations' => 'array',
        'volumes' => 'array',
        'packaging' => 'array',
        'closures' => 'array',
    ];

    public function readAllProduct()
    {
        return DB::table('products as P')
            ->select("P.*", 'P.id as id',
                    'C.name as category',
                    'S.name as subcategory',
                    'V.name as variation',
                    )
            ->leftJoin('subcategory as S', 'S.id', '=', 'P.sub_category_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
            ->get();
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class);
    }

}
