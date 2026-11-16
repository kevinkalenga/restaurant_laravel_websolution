<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class MenuItem extends Model
{
    protected $table = 'catering_menu_items';
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

     

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_menu_item',
            'menu_item_id',
            'product_id'
        )
        ->withPivot('quantity')
        ->withTimestamps();
    }

    
    public function cateringMenus(): BelongsToMany
    {
        return $this->belongsToMany(
            Menu::class,
            'catering_menu_item',
            'menu_item_id',
            'catering_menu_id'
        )
        ->withPivot('quantity')
        ->withTimestamps();
    }

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(
            Allergen::class,
            'allergen_catering_menu_item',
            'menu_item_id',
            'allergen_id'
        )->withTimestamps();
    }
}
