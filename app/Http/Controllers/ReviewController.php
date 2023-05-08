<?php

namespace App\Http\Controllers;

use App\Models\Image;
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

        $review->save();

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $filename = time() . '-' . $image->getClientOriginalName();
                $path = $image->storeAs('public/img', $filename);
                $image = new Image;
                $image->review_id = $review->id;
                $image->name = $filename;
                $image->url = $path;
                $image->save();
            }
        }

        return redirect()->back()->with('success', 'Reseña agregada correctamente');
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->comment = $request->input('comment');

        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/img', $imageName);
                $images[] = $imageName;
            }
            $review->images = $images;
        }

        $review->save();

        return redirect()->back();
    }
}
