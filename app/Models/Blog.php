<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
      protected $fillable = [
            'user_id',
            'image',
            'title',
            'slug',
            'category_id',
            'description',
            'seo_title',
            'seo_description',
            'status',
    ];

    public function category()
    {
      //signifie qu’un Blog appartient à une BlogCategory via category_id.
      return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }
    
    public function user()
    {
      //signifie qu’un Blog appartient à une BlogCategory via user_id.
      return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
