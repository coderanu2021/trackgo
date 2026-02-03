<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Review;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'page_id' => 'required|exists:pages,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'review_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Combine rules with conditional guest rules
        if (!auth()->check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        // Check if user has purchased this product (helper for "Verified" badge logic if we had it, but mostly just to tag user)
        // We no longer block non-purchasers.
        
        $user = auth()->user();

        $imagePaths = [];
        if ($request->hasFile('review_images')) {
            foreach ($request->file('review_images') as $image) {
                $path = $image->store('uploads/reviews', 'public');
                $imagePaths[] = asset('storage/' . $path);
            }
        }

        Review::create([
            'page_id' => $request->page_id,
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : $request->name,
            'email' => $user ? $user->email : $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
            'is_approved' => false, // Guest reviews require approval.
        ]);

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted for approval.');
    }

    public function index()
    {
        // For the "revive page" (all reviews page)
        $reviews = Review::where('is_approved', true)->with('product')->latest()->paginate(20);
        return view('front.reviews', compact('reviews'));
    }
}
