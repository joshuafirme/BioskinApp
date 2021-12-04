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
        'variation_code',
        'name',
        'price',
        'description',
        'directions',
        'precautions',
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
                    'V.name as variation',
                    )
            ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
            ->get();
    }

    public function packaging()
    {
        return $this->belongsTo(Packaging::class);
    }

    public function readVariations($variation_code) {
        return Product::where('variation_code', $variation_code)
                        ->select('products.sku','V.name as variation')
                        ->leftJoin('variations as V', 'V.id', '=', 'products.variation_id')
                        ->get();
    }

    
    public function readRetail($sku) {
     

    }

}
