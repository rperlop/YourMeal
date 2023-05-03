<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);

        $review = new Review;
        $review->user_id = Auth::user()->id;
        $review->restaurant_id = $request->restaurant_id;
        $review->comment = $request->comment;
        $review->save();

        return back()->with('success', 'Your comment has been posted.');
    }
}
