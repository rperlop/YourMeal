<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller {
    /**
     * Create or update a new review
     *
     * @param Request $request
     * @param         $restaurant_id
     * @param         $updating
     *
     * @return RedirectResponse
     */
    public function store( Request $request, $restaurant_id, $updating ): RedirectResponse {
        $validator = Validator::make( $request->all(), [
            'rate'     => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ], [
            'rate.required'  => 'The rate is mandatory.',
            'images.*.image' => 'The file must be an image.',
            'images.*.max'   => 'The image size can not exceed 2MB.',
        ] );

        if ( $validator->fails() ) {
            return back()
                ->withErrors( $validator )
                ->withInput()
                ->with( 'formSubmitted', true );
        }

        if ( $updating ) {
            $user_review = Review::where( 'restaurant_id', $restaurant_id )->where( 'user_id', Auth::user()->id )->first();

            $user_review->rate    = $request->input( 'rate' );
            $user_review->comment = $request->input( 'description' );

            if ( $request->hasFile( 'images' ) ) {
                $user_review->images()->delete();
                $images = $request->file( 'images' );
                foreach ( $images as $image ) {
                    $filename         = time() . '-' . $image->getClientOriginalName();
                    $path             = $image->storeAs( 'public/img', $filename );
                    $image            = new Image;
                    $image->review_id = $user_review->id;
                    $image->name      = $filename;
                    $image->url       = $path;
                    $image->save();
                }
            }

            $user_review->save();
        } else {
            $review                = new Review;
            $review->restaurant_id = $restaurant_id;
            $review->user_id       = Auth::user()->id;
            $review->rate          = $request->input( 'rate' );
            $review->comment       = $request->input( 'description' );

            $review->save();

            if ( $request->hasFile( 'images' ) ) {
                $images = $request->file( 'images' );
                foreach ( $images as $image ) {
                    $filename         = time() . '-' . $image->getClientOriginalName();
                    $path             = $image->storeAs( 'public/img', $filename );
                    $image            = new Image;
                    $image->review_id = $review->id;
                    $image->name      = $filename;
                    $image->url       = $path;
                    $image->save();
                }
            }
        }

        if ( $updating ) {
            toastr()->success( 'Review updated.' );
        } else {
            toastr()->success( 'Review created.' );
        }

        return redirect()->back();
    }
}
