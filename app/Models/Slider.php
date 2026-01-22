<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
     use HasFactory;

    // Ajouter les colonnes autorisées pour le mass assignment
    protected $fillable = [
        'image',
        'offer',
        'title',
        'sub_title',
        'short_description',
        'button_link',
        'status',
    ];
}
