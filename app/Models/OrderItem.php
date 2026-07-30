<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_name',
        'product_id',
        'unit_price',
        'qty',
        'product_size',
        'product_option',
    ];


    protected $casts = [
        'product_size' => 'array',
        'product_option' => 'array',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
