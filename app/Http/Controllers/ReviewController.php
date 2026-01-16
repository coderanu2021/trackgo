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
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'You must be logged in to leave a review.');
        }

        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'review_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Check if user has purchased this product
        $hasPurchased = \App\Models\OrderItem::where('product_page_id', $request->page_id)
            ->whereHas('order', function($q) {
                $q->where('user_id', auth()->id());
            })->exists();

        if (!$hasPurchased) {
            return redirect()->back()->with('error', 'Only customers who have purchased this product can leave a review.');
        }

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
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
            'is_approved' => true,
        ]);

        return redirect()->back()->with('success', 'Thank you for your verified purchase review!');
    }

    public function index()
    {
        // For the "revive page" (all reviews page)
        $reviews = Review::where('is_approved', true)->with('product')->latest()->paginate(20);
        return view('front.reviews', compact('reviews'));
    }
}
