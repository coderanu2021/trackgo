<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionLog extends Model
{
    protected $fillable = ['subscription_id', 'type', 'message', 'status', 'sent_at'];
    
    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
