<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $subscribers = Newsletter::latest()->get();
        return view('admin.newsletters.index', compact('subscribers'));
    }

    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();
        return redirect()->route('admin.newsletters.index')->with('success', 'Subscriber removed successfully.');
    }

    public function toggle(Newsletter $newsletter)
    {
        $newsletter->update([
            'is_active' => !$newsletter->is_active
        ]);
        return redirect()->route('admin.newsletters.index')->with('success', 'Subscriber status updated.');
    }
}
