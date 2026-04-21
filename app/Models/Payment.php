<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'transaction_id', 'payment_type', 'amount', 'status', 'snap_token', 'midtrans_response'
    ];

    protected $casts = [
        'midtrans_response' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
