<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{

    protected $table = 'subcategory';

    protected $fillable = [
        'name',
        'category_id',
        'status'
    ];

    public function readSubcategoryByCategory($category_id) {
        return $this::select('subcategory.*', 'C.name as subcategory', 'C.id as cat_id')
            ->where('subcategory.category_id', $category_id)
            ->where('subcategory.status', 1)
            ->leftJoin('category as C', 'C.id', '=', 'subcategory.category_id')
            ->get();
    }
}
