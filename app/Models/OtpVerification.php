<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class OtpVerification extends Model
{
    protected $fillable = [
        'phone_number',
        'otp_code',
        'type',
        'is_verified',
        'expires_at',
        'verified_at',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime'
    ];

    public function isExpired()
    {
        return $this->expires_at->isPast();
    }

    public function isValid()
    {
        return !$this->is_verified && !$this->isExpired();
    }

    public function markAsVerified()
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now()
        ]);
    }

    public static function generateOtp()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public static function createForPhone($phoneNumber, $type = 'login')
    {
        // Invalidate previous OTPs for this phone
        static::where('phone_number', $phoneNumber)
              ->where('type', $type)
              ->where('is_verified', false)
              ->update(['is_verified' => true]); // Mark as used

        return static::create([
            'phone_number' => $phoneNumber,
            'otp_code' => static::generateOtp(),
            'type' => $type,
            'expires_at' => now()->addMinutes(10), // 10 minutes expiry
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }

    public static function verifyOtp($phoneNumber, $otpCode, $type = 'login')
    {
        $otp = static::where('phone_number', $phoneNumber)
                    ->where('otp_code', $otpCode)
                    ->where('type', $type)
                    ->where('is_verified', false)
                    ->where('expires_at', '>', now())
                    ->first();

        if ($otp) {
            $otp->markAsVerified();
            return true;
        }

        return false;
    }
}
