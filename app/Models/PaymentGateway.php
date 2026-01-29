<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'display_name',
        'description',
        'config',
        'is_active',
        'is_test_mode',
        'supported_currencies',
        'min_amount',
        'max_amount',
        'logo',
        'sort_order'
    ];

    protected $casts = [
        'config' => 'json',
        'supported_currencies' => 'json',
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'gateway', 'slug');
    }

    public function isActive()
    {
        return $this->is_active;
    }

    public function supportsCurrency($currency)
    {
        if (!$this->supported_currencies) {
            return true; // If no specific currencies defined, support all
        }
        
        return in_array($currency, $this->supported_currencies);
    }

    public function supportsAmount($amount)
    {
        if ($amount < $this->min_amount) {
            return false;
        }

        if ($this->max_amount && $amount > $this->max_amount) {
            return false;
        }

        return true;
    }

    public function getConfig($key = null)
    {
        if ($key) {
            return $this->config[$key] ?? null;
        }

        return $this->config;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCurrency($query, $currency)
    {
        return $query->where(function ($q) use ($currency) {
            $q->whereNull('supported_currencies')
              ->orWhereJsonContains('supported_currencies', $currency);
        });
    }
}
