<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'catering_menus';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'price',
        'minimum_persons',
        'theme',
        'diet',
        'available_stock',
        'advance_notice_hours',
        'storage_conditions',
        'order_conditions',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'minimum_persons' => 'integer',
        'available_stock' => 'integer',
        'advance_notice_hours' => 'integer',
        'status' => 'boolean',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('dish_type', 'quantity')
            ->withTimestamps();
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(MenuGallery::class);
    }
}
