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
        $request->validate([
            'page_id' => 'required|exists:pages,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'name' => 'required_if:user_id,null|string|max:255',
            'email' => 'required_if:user_id,null|email|max:255',
            'review_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('review_images')) {
            foreach ($request->file('review_images') as $image) {
                $path = $image->store('uploads/reviews', 'public');
                $imagePaths[] = asset('storage/' . $path);
            }
        }

        Review::create([
            'page_id' => $request->page_id,
            'user_id' => auth()->id(),
            'name' => auth()->check() ? auth()->user()->name : $request->name,
            'email' => auth()->check() ? auth()->user()->email : $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'images' => $imagePaths,
            'is_approved' => true, // Auto approve for now as requested by user's "dont change structure" vibe
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    public function index()
    {
        // For the "revive page" (all reviews page)
        $reviews = Review::where('is_approved', true)->with('product')->latest()->paginate(20);
        return view('front.reviews', compact('reviews'));
    }
}
