<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'payment_id',
        'gateway_payment_id',
        'order_id',
        'gateway',
        'amount',
        'currency',
        'status',
        'gateway_response',
        'metadata',
        'paid_at'
    ];

    protected $casts = [
        'gateway_response' => 'json',
        'metadata' => 'json',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function gateway()
    {
        return $this->belongsTo(PaymentGateway::class, 'gateway', 'slug');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isFailed()
    {
        return $this->status === 'failed';
    }

    public function generatePaymentId()
    {
        return 'PAY_' . strtoupper(uniqid()) . '_' . time();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (!$payment->payment_id) {
                $payment->payment_id = $payment->generatePaymentId();
            }
        });
    }
}
