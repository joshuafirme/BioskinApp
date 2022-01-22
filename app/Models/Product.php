<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\Packaging;
use App\Models\Category;
use App\Models\Subcategory;

class Product extends Model
{

    protected $fillable = [
        'sku',
        'variation_code',
        'name',
        'qty',
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
        'packaging_price_included',
        'closure_price_included'

    ];

    protected $casts = [
        'variations' => 'array',
        'volumes' => 'array',
        'packaging' => 'array',
        'closures' => 'array',
    ];

    public function readAllProduct($object)
    {
        if ($object == 'packaging') {
            return $this->readAllPackaging();
        }
        else {
            return DB::table('products as P')
                ->select("P.*", 'P.id as id',
                        'V.name as variation',
                        )
                ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
                ->whereNotIn('category_id', [10])
                ->where('status', 1)
                ->get();
        }

    }

    public function readArchiveProduct($per_page)
    {
        return DB::table('products as P')
        ->select("P.*", 'P.id as id',
                'V.name as variation',
                )
        ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
        ->where('status', 0)
        ->paginate($per_page);
    }

    public function readAllPackaging()
    {
        return DB::table('products as P')
            ->select("P.*", 'P.id as id',
                    'V.name as variation',
                    )
            ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
            ->whereIn('category_id', [10])
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

    
    public function readOneProduct($sku) {
        return DB::table('products as P')
        ->select('P.sku', 'P.name as name', 'P.price', 'P.size', 'P.qty as stock', 'V.name as variation', 'category.name as category')
        ->where('sku', $sku)
        ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
        ->leftJoin('category', 'category.id', '=', 'P.category_id')
        ->first(); 
    }

    public function readImages($sku) {
        return DB::table('product_images')->select('image')->where('sku',$sku)->value('image');
    }

    public function readProductBySKU($sku) {
        return DB::table('products as P')
                    ->select('P.sku', 'P.name as name', 'P.price', 'P.size', 'P.qty as stock', 'V.name as variation', 'category.name as category')
                    ->leftJoin('variations as V', 'V.id', '=', 'P.variation_id')
                    ->leftJoin('category', 'category.id', '=', 'P.category_id')
                    ->where('P.qty','>', '0')
                    ->where('P.sku', $sku)
                    ->get();
    }

    public function isPackagingPriceIncluded($sku) {
        $res = DB::table('products')->where('sku',$sku)->value('packaging_price_included');
        return $res == 1 ? true : false;
    }

    public function isCapPriceIncluded($sku) {
        return DB::table('products')->where('sku',$sku)->value('closure_price_included');
    }

    public function readPriceBySKU($sku) {
        return DB::table('products')->where('sku',$sku)->value('price');
    }

    public function readPackagingPriceByID($id) {
        $res = DB::table('products')->where('id',$id)->value('price');
        return $res ? $res : 0;
    }

    public function readPackagingNameByID($id) {

        return DB::table('products')
        ->select('name', 'size')
        ->where('id', $id)->value('name');
        
    }

    public function readDefaultPackagingBySKU($sku) {

        $packaging_id = $this->readDefaultPackagingID($sku);

        return DB::table('products')
        ->select('name', 'size')
        ->where('id', $packaging_id)->value('name');
        
    }
    
    public function readDefaultCapBySKU($sku) {

        $cap_id = $this->readDefaultCapID($sku);

        return DB::table('products')
        ->select('name', 'size')
        ->where('id', $cap_id)->value('name');
        
    }

    public function readDefaultPackagingID($sku) {

        $packaging = $this::where('sku', $sku)->value('packaging');
        if ($packaging) {
            return $packaging[0];
        }
        else {
            return '';
        }
    }

    public function readDefaultCapID($sku) {
        
        $closure = $this::where('sku', $sku)->value('closures');
        if ($closure) {
            return $closure[0];
        }
        else {
            return '';
        }
    }
}
