<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewsletterWelcome;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email',
        ], [
            'email.unique' => 'This email is already subscribed to our newsletter.',
            'email.email' => 'Please provide a valid email address.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        Newsletter::create([
            'email' => $request->email,
            'is_active' => true
        ]);

        // Send Welcome Email
        try {
            Mail::to($request->email)->send(new NewsletterWelcome());
        } catch (\Exception $e) {
            // Silently fail if mail config is not set up correctly
        }

        return response()->json([
            'success' => true,
            'message' => 'Welcome to the inner circle! 🚀<br><small>Enjoy 15% OFF your first order with code: <strong>WELCOME15</strong></small>'
        ]);
    }
}
