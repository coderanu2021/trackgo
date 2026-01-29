<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin-login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function showRegister()
    {
        // Redirect regular users to WhatsApp login
        return redirect()->route('whatsapp.login')
                        ->with('info', 'Please use WhatsApp login for customer registration');
    }

    public function register(Request $request)
    {
        // Only allow admin registration (or disable completely)
        return redirect()->route('whatsapp.login')
                        ->with('info', 'Please use WhatsApp login for registration');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Only allow admin users to login via email/password
            if (!$user->isAdmin()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Admin access only. Please use WhatsApp login for customer access.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
