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
        return $this::where('category_id', $category_id)->get();
    }
}
