<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $recent_orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        $total_orders = Order::where('user_id', $user->id)->count();
        
        return view('customer.dashboard', compact('user', 'recent_orders', 'total_orders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
