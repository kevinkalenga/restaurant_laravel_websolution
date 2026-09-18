<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
       protected $fillable = [
        'image',
        'name',
        'title',
        'fb',
        'in',
        'x',
        'web',
        'show_at_home',
        'status',
    ];
}
