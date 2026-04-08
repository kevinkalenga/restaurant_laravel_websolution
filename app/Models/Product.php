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
    // the product can have multiple images
    public function productImages()
    {
         return $this->hasMany(ProductGallery::class);
    }
    // the product can have multiple size
    public function productSizes()
    {
         return $this->hasMany(ProductSize::class);
    }
    public function productOptions()
    {
         return $this->hasMany(ProductOption::class);
    }
}
