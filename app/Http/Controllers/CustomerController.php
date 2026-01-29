<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show customer dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
                            ->latest()
                            ->take(5)
                            ->get();
        
        // Get order statistics
        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)
                             ->where('status', 'pending')
                             ->count();
        $completedOrders = Order::where('user_id', $user->id)
                                ->where('status', 'completed')
                                ->count();
        
        return view('customer.dashboard', compact(
            'user', 
            'recentOrders', 
            'totalOrders', 
            'pendingOrders', 
            'completedOrders'
        ));
    }

    /**
     * Show customer orders
     */
    public function orders()
    {
        $user = Auth::user();
        
        $orders = Order::where('user_id', $user->id)
                      ->with(['items.product'])
                      ->latest()
                      ->paginate(10);
        
        return view('customer.orders', compact('orders'));
    }

    /**
     * Show customer profile
     */
    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    /**
     * Update customer profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $updateData = [
            'name' => $request->name,
        ];

        if ($request->email) {
            $updateData['email'] = $request->email;
        }

        if ($request->phone && $request->phone !== $user->phone) {
            $updateData['phone'] = $request->phone;
            $updateData['phone_verified_at'] = null; // Reset verification if phone changed
        }

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return back()->with('success', 'Profile updated successfully!');
    }
}