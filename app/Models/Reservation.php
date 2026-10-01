<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_id',
        'name',
        'phone',
        'date',
        'time',
        'persons',
        'status',
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
