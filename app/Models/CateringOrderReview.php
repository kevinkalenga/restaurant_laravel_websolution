<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CateringOrderReview extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'rating',
        'review',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
