<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = [
        'name',
        'wording',
        'status',
        'image',
    ];

    public function getCategoryName($category_id) {
        if ($category_id != 0) {
            return $this::where('id', $category_id)->pluck('name')[0];
        }
        else {
            return "";
        }
    }

    public function getCategoryIDByName($category_name) {
        if ($category_name != "") {
            return $this::where('name', $category_name)->value('id');
        }
        else {
            return "";
        }
    }
}
