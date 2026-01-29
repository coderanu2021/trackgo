<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'login_type',
        'is_phone_primary',
        'phone_verified_at',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isPhoneUser()
    {
        return $this->login_type === 'phone';
    }

    public function isEmailUser()
    {
        return $this->login_type === 'email';
    }

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function markPhoneAsVerified()
    {
        $this->forceFill([
            'phone_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Find user by phone number
     */
    public static function findByPhone($phone)
    {
        return static::where('phone', $phone)->first();
    }

    /**
     * Create or update user with phone
     */
    public static function createOrUpdateByPhone($phone, $name = null)
    {
        $user = static::findByPhone($phone);
        
        if ($user) {
            return $user;
        }

        return static::create([
            'name' => $name ?: 'User',
            'phone' => $phone,
            'login_type' => 'phone',
            'is_phone_primary' => true,
            'phone_verified_at' => now(),
        ]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_phone_primary' => 'boolean',
        ];
    }
}
