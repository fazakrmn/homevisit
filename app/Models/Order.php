<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'total_amount',
        'status',
        'snap_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
