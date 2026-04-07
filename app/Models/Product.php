<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    
    // each(id or product) belong to a category => category_id column inside product
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
