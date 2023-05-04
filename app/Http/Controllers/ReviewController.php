<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $restaurantId)
    {
        $restaurant = Restaurant::findOrFail($restaurantId);

        $review = new Review;
        $review->restaurant_id = $restaurant->id;
        $review->user_id = Auth::user()->id;
        $review->rate = $request->input('rating');
        $review->comment = $request->input('comment');

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('reviews');
                $images[] = $path;
            }
            $review->image = json_encode($images);
        }

        $review->save();

        return redirect()->back()->with('success', 'Reseña agregada correctamente');
    }
}
