<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    //A single category can have many posts
    public function blogs()
    {
        // id from blogs table and category_id from blog_categories table
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }
}
