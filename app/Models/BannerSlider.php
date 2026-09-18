<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BannerSlider extends Model
{
     // Ajouter les colonnes autorisées pour le mass assignment
    protected $fillable = [
        'banner',
        'title',
        'sub_title',
        'status',
    ];
}
