<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Packaging extends Model
{

    protected $table = 'packaging';

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

    public function readAll()
    {
        return DB::table('packaging as P')
            ->select("P.*",
                    'C.name as category',
                    'S.name as subcategory',
                    )
            ->leftJoin('subcategory as S', 'S.id', '=', 'P.sub_category_id')
            ->leftJoin('category as C', 'C.id', '=', 'P.category_id')
            ->paginate(10);
    }
    
}
