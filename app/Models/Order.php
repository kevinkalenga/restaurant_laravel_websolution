<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderStatusHistory;

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
        'equipment_loaned',
        'catering_menu_id',
        'delivery_date',
        'delivery_time',
        'number_of_persons',
        'catering_first_name',
        'catering_last_name',
        'catering_email',
        'catering_phone',
        'service_location',
    ];

    protected $casts = [
      'delivery_date' => 'date',
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

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class)
            ->orderBy('created_at', 'asc');
    }

    public function cateringMenu()
    {
        return $this->belongsTo(\App\Models\Menu::class, 'catering_menu_id');
    }
}
