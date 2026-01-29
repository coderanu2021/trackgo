<?php

namespace App\Services;

use App\Models\OtpVerification;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppOtpService
{
    protected $apiUrl;
    protected $apiKey;
    protected $fromNumber;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.api_url');
        $this->apiKey = config('services.whatsapp.api_key');
        $this->fromNumber = config('services.whatsapp.from_number');
    }

    /**
     * Send OTP via WhatsApp
     */
    public function sendOtp($phoneNumber, $type = 'login')
    {
        try {
            // Clean phone number (remove spaces, dashes, etc.)
            $cleanPhone = $this->cleanPhoneNumber($phoneNumber);
            
            // Create OTP record
            $otpRecord = OtpVerification::createForPhone($cleanPhone, $type);
            
            // Prepare message
            $message = $this->prepareOtpMessage($otpRecord->otp_code, $type);
            
            // Send via WhatsApp API (simulated for now)
            $result = $this->sendWhatsAppMessage($cleanPhone, $message);
            
            if ($result['success']) {
                Log::info('WhatsApp OTP sent successfully', [
                    'phone' => $cleanPhone,
                    'otp_id' => $otpRecord->id,
                    'type' => $type
                ]);

                return [
                    'success' => true,
                    'message' => 'OTP sent successfully to your WhatsApp',
                    'otp_id' => $otpRecord->id,
                    'expires_in' => 600 // 10 minutes
                ];
            } else {
                throw new Exception($result['message'] ?? 'Failed to send WhatsApp message');
            }

        } catch (Exception $e) {
            Log::error('WhatsApp OTP sending failed', [
                'phone' => $phoneNumber,
                'error' => $e->getMessage(),
                'type' => $type
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp($phoneNumber, $otpCode, $type = 'login')
    {
        try {
            $cleanPhone = $this->cleanPhoneNumber($phoneNumber);
            
            $isValid = OtpVerification::verifyOtp($cleanPhone, $otpCode, $type);
            
            if ($isValid) {
                Log::info('WhatsApp OTP verified successfully', [
                    'phone' => $cleanPhone,
                    'type' => $type
                ]);

                return [
                    'success' => true,
                    'message' => 'OTP verified successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid or expired OTP'
                ];
            }

        } catch (Exception $e) {
            Log::error('WhatsApp OTP verification failed', [
                'phone' => $phoneNumber,
                'otp' => $otpCode,
                'error' => $e->getMessage(),
                'type' => $type
            ]);

            return [
                'success' => false,
                'message' => 'OTP verification failed. Please try again.',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Clean phone number format
     */
    protected function cleanPhoneNumber($phoneNumber)
    {
        // Remove all non-numeric characters
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Add country code if not present (assuming India +91)
        if (strlen($cleaned) === 10) {
            $cleaned = '91' . $cleaned;
        }
        
        return $cleaned;
    }

    /**
     * Prepare OTP message
     */
    protected function prepareOtpMessage($otpCode, $type)
    {
        $siteName = config('app.name', 'TrackGo');
        
        switch ($type) {
            case 'login':
                return "🔐 Your {$siteName} login OTP is: *{$otpCode}*\n\nThis OTP is valid for 10 minutes. Do not share this code with anyone.\n\n- {$siteName} Team";
                
            case 'registration':
                return "🎉 Welcome to {$siteName}!\n\nYour verification OTP is: *{$otpCode}*\n\nThis OTP is valid for 10 minutes.\n\n- {$siteName} Team";
                
            case 'password_reset':
                return "🔑 Your {$siteName} password reset OTP is: *{$otpCode}*\n\nThis OTP is valid for 10 minutes. If you didn't request this, please ignore.\n\n- {$siteName} Team";
                
            default:
                return "Your {$siteName} OTP is: *{$otpCode}*\n\nValid for 10 minutes.";
        }
    }

    /**
     * Send WhatsApp message via API
     * This is a placeholder - integrate with your preferred WhatsApp API provider
     */
    protected function sendWhatsAppMessage($phoneNumber, $message)
    {
        // For development/testing, we'll simulate success
        if (app()->environment('local')) {
            Log::info('WhatsApp OTP (Development Mode)', [
                'phone' => $phoneNumber,
                'message' => $message
            ]);
            
            return [
                'success' => true,
                'message' => 'Message sent successfully (development mode)'
            ];
        }

        // Production implementation with actual WhatsApp API
        try {
            // Example with a generic WhatsApp API provider
            if (!$this->apiUrl || !$this->apiKey) {
                throw new Exception('WhatsApp API credentials not configured');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json'
            ])->post($this->apiUrl . '/messages', [
                'to' => $phoneNumber,
                'from' => $this->fromNumber,
                'type' => 'text',
                'text' => [
                    'body' => $message
                ]
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'WhatsApp message sent successfully',
                    'response' => $response->json()
                ];
            } else {
                throw new Exception('WhatsApp API error: ' . $response->body());
            }

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp($phoneNumber, $type = 'login')
    {
        // Check if enough time has passed since last OTP (prevent spam)
        $lastOtp = OtpVerification::where('phone_number', $this->cleanPhoneNumber($phoneNumber))
                                 ->where('type', $type)
                                 ->latest()
                                 ->first();

        if ($lastOtp && $lastOtp->created_at->diffInMinutes(now()) < 1) {
            return [
                'success' => false,
                'message' => 'Please wait at least 1 minute before requesting a new OTP'
            ];
        }

        return $this->sendOtp($phoneNumber, $type);
    }
}