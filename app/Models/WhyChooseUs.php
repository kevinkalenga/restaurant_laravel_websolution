<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WhyChooseUs extends Model
{
      use HasFactory;
      protected $fillable = [
        'icon',
        'title',
        'short_description',
        'status'
      ];
}
