<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Closures extends Model
{

    protected $table = 'closures';

    protected $fillable = [
        'sku',
        'name',
        'price',
        'description',
        'category_id',
        'sub_category_id',
        'size',
        'volumes',
    ];

    public function readClosuresByPackaging($packaging_id) {
        return $this::where('packaging_id', $packaging_id)->get();
    }

    public function readAll()
    {
        return DB::table('closures as P')
            ->select("P.*",
                    'C.name as category',
                    'S.name as subcategory',
                    )
            ->leftJoin('subcategory as S', 'S.id', '=', 'P.sub_category_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->paginate(10);
    }
}
