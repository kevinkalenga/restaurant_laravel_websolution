<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class OrderStatistic extends Model
{
    protected $connection = 'mongodb';

    protected $collection = 'order_statistics';

    protected $fillable = [
        'menu_id',
        'menu_name',
        'total_orders',
        'date',
    ];
}