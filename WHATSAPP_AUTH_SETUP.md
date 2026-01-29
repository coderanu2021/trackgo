# WhatsApp OTP Authentication System

## Overview
The application now supports dual authentication:
- **Customers**: Login via WhatsApp OTP
- **Admins**: Login via email/password

## Features Implemented

### 1. WhatsApp OTP Authentication
- Phone number-based user registration and login
- 6-digit OTP generation and verification
- OTP expiry (10 minutes)
- Resend OTP functionality
- Rate limiting to prevent spam

### 2. Dual Authentication System
- Customers use WhatsApp login at `/whatsapp-login`
- Admins use email login at `/admin/login`
- Automatic redirection based on user type

### 3. Database Changes
- Added `otp_verifications` table for OTP management
- Extended `users` table with phone-related fields:
  - `phone` (nullable, unique)
  - `phone_verified_at`
  - `login_type` (email/phone)
  - `is_phone_primary`

### 4. User Interface
- Modern WhatsApp-themed login interface
- Admin-specific login page
- Updated header to show WhatsApp login for customers
- Customer dashboard and profile support for phone users

## Routes Added

```php
// WhatsApp Authentication
Route::get('whatsapp-login', [WhatsAppAuthController::class, 'showLoginForm'])->name('whatsapp.login');
Route::post('whatsapp/send-otp', [WhatsAppAuthController::class, 'sendOtp'])->name('whatsapp.send-otp');
Route::post('whatsapp/verify-otp', [WhatsAppAuthController::class, 'verifyOtp'])->name('whatsapp.verify-otp');
Route::post('whatsapp/resend-otp', [WhatsAppAuthController::class, 'resendOtp'])->name('whatsapp.resend-otp');

// Admin Login
Route::get('admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
```

## Configuration

### Environment Variables
Add to your `.env` file:
```env
# WhatsApp API Configuration
WHATSAPP_API_URL=your_whatsapp_api_url
WHATSAPP_API_KEY=your_api_key
WHATSAPP_FROM_NUMBER=your_whatsapp_number
```

### WhatsApp API Integration
The system is designed to work with any WhatsApp API provider. Currently configured for:
- Development mode: Logs OTP to Laravel log files
- Production mode: Sends via configured WhatsApp API

Popular WhatsApp API providers:
- Twilio WhatsApp API
- WhatsApp Business API
- 360Dialog
- Gupshup

## Testing

### Admin Login
- URL: `/admin/login`
- Email: `admin@trackgo.com`
- Password: `admin123`

### Customer WhatsApp Login
- URL: `/whatsapp-login`
- Enter any 10-digit phone number
- In development mode, OTP is logged to `storage/logs/laravel.log`

## Files Created/Modified

### New Files
- `app/Http/Controllers/WhatsAppAuthController.php`
- `app/Services/WhatsAppOtpService.php`
- `app/Models/OtpVerification.php`
- `app/Http/Controllers/CustomerController.php`
- `resources/views/auth/whatsapp-login.blade.php`
- `resources/views/auth/admin-login.blade.php`
- `database/migrations/2026_01_29_084406_create_otp_verifications_table.php`
- `database/migrations/2026_01_29_085844_add_phone_to_users_table.php`

### Modified Files
- `app/Models/User.php` - Added phone authentication methods
- `app/Http/Controllers/AuthController.php` - Admin-only email login
- `routes/web.php` - Added WhatsApp and admin routes
- `config/services.php` - Added WhatsApp API configuration
- `resources/views/layouts/front.blade.php` - Updated login links
- `resources/views/customer/profile.blade.php` - Phone user support

## Security Features

1. **OTP Validation**: 6-digit codes with 10-minute expiry
2. **Rate Limiting**: Prevents OTP spam (1-minute cooldown)
3. **Phone Verification**: Automatic phone verification on successful OTP
4. **Session Management**: Proper session handling and regeneration
5. **Admin Separation**: Admins can only login via email/password

## Next Steps

1. **WhatsApp API Setup**: Configure with your preferred WhatsApp API provider
2. **Phone Number Validation**: Add country code validation if needed
3. **SMS Fallback**: Optionally add SMS OTP as fallback
4. **Two-Factor Authentication**: Add 2FA for admin accounts
5. **Phone Number Verification**: Add phone number change verification

## Usage

### For Customers
1. Visit the homepage
2. Click "Login" (WhatsApp icon)
3. Enter phone number
4. Receive OTP on WhatsApp
5. Enter OTP and optional name
6. Access customer dashboard

### For Admins
1. Visit `/admin/login`
2. Enter email and password
3. Access admin dashboard

The system automatically redirects users to appropriate dashboards based on their role.