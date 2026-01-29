<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WhatsAppOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WhatsAppAuthController extends Controller
{
    protected $whatsappOtpService;

    public function __construct(WhatsAppOtpService $whatsappOtpService)
    {
        $this->whatsappOtpService = $whatsappOtpService;
    }

    /**
     * Show WhatsApp login form
     */
    public function showLoginForm()
    {
        return view('auth.whatsapp-login');
    }

    /**
     * Send OTP to phone number
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15|regex:/^[0-9+\-\s]+$/'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid phone number',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $phone = $request->phone;
        $type = $request->type ?? 'login';

        // Send OTP
        $result = $this->whatsappOtpService->sendOtp($phone, $type);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', $result['message'])
                        ->with('phone', $phone)
                        ->with('otp_sent', true);
        } else {
            return back()->with('error', $result['message'])->withInput();
        }
    }

    /**
     * Verify OTP and login user
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'otp' => 'required|string|size:6',
            'name' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please provide valid phone number and OTP',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $phone = $request->phone;
        $otp = $request->otp;
        $name = $request->name;
        $type = $request->type ?? 'login';

        // Verify OTP
        $result = $this->whatsappOtpService->verifyOtp($phone, $otp, $type);

        if ($result['success']) {
            // Find or create user
            $user = User::findByPhone($phone);
            
            if (!$user) {
                // Create new user for phone login
                $user = User::createOrUpdateByPhone($phone, $name);
            }

            // Login the user
            Auth::login($user, true); // Remember user

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful!',
                    'redirect_url' => $this->getRedirectUrl($user)
                ]);
            }

            return redirect()->intended($this->getRedirectUrl($user))
                           ->with('success', 'Welcome! You have been logged in successfully.');
        } else {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message']
                ], 422);
            }

            return back()->with('error', $result['message'])
                        ->with('phone', $phone)
                        ->with('otp_sent', true)
                        ->withInput();
        }
    }

    /**
     * Resend OTP
     */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number is required',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator);
        }

        $phone = $request->phone;
        $type = $request->type ?? 'login';

        $result = $this->whatsappOtpService->resendOtp($phone, $type);

        if ($request->ajax()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', $result['message'])
                        ->with('phone', $phone)
                        ->with('otp_sent', true);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Get redirect URL based on user type
     */
    protected function getRedirectUrl($user)
    {
        if ($user->isAdmin()) {
            return route('admin.dashboard');
        }

        return route('customer.dashboard');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully'
            ]);
        }

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
