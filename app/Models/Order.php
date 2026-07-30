<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_id',
        'user_id',
        'address',
        'discount',
        'delivery_charge',
        'subtotal',
        'grand_total',
        'product_qty',
        'payment_method',
        'payment_status',
        'payment_approve_date',
        'transaction_id',
        'coupon_info',
        'currency_name',
        'order_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function deliveryArea()
    {
        return $this->belongsTo(DeliveryArea::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
