<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
       // Ajouter les colonnes autorisées pour le mass assignment
    protected $fillable = [
            'image',
            'name',
            'title',
            'rating',
            'review',
            'show_at_home',
            'status',
    ];
}
