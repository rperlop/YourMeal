<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Notification;
use App\Models\Report;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
            'rate'     => 'required|numeric|min:1|max:5',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ], [
            'rate.required'  => 'The rate is mandatory.',
            'rate.numeric'   => 'The rate must be a numeric value.',
            'rate.min'       => 'The rate must be at least 1.',
            'rate.max'       => 'The rate cannot exceed 5.',
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

    /**
     * Index all the reviews
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index_reviews(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $reviews = Review::where( function ( $query ) {
            $query->whereNotNull( 'comment' )
                  ->where( 'comment', '<>', '' )
                  ->orWhereHas( 'images' );
        } )
                         ->with( 'restaurant', 'user', 'reports' )
                         ->get();

        return view( 'admin.pages.index-reviews', compact( 'reviews' ) );
    }

    /**
     * Show a review
     *
     * @param integer $id
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show_review( int $id ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $review = Review::with( 'user', 'images', 'reports' )->find( $id );

        return view( 'admin.pages.show-review', compact( 'review' ) );
    }

    /**
     * Delete a review
     *
     * @param integer $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function delete( int $id ): \Illuminate\Contracts\Foundation\Application|Factory|View|Application {
        $review = Review::find( $id );

        $review->reports()->delete();

        $review->notifications()->delete();

        foreach ( $review->images as $image ) {
            Storage::delete( $image->url );
            $image->delete();
        }

        $review->delete();

        $reviews = Review::where( function ( $query ) {
            $query->whereNotNull( 'comment' )
                  ->where( 'comment', '<>', '' )
                  ->orWhereHas( 'images' );
        } )
                         ->with( 'restaurant', 'user', 'reports' )
                         ->get();

        return view( 'admin.pages.index-reviews', compact( 'reviews' ) );
    }

    /**
     * Delete a review and add a strike to a user
     *
     * @param integer $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function delete_with_strike( int $id ): \Illuminate\Contracts\Foundation\Application|Factory|View|Application {
        $review = Review::find( $id );

        $review->reports()->delete();

        $review->notifications()->delete();

        foreach ( $review->images as $image ) {
            Storage::delete( $image->url );
            $image->delete();
        }

        $user = $review->user;
        $user->strikes++;
        $user->notify = 1;
        $user->save();

        $notifications = Notification::where( 'review_id', $review->id );
        $notifications->delete();

        $review->delete();

        $reviews = Review::where( function ( $query ) {
            $query->whereNotNull( 'comment' )
                  ->where( 'comment', '<>', '' )
                  ->orWhereHas( 'images' );
        } )
                         ->with( 'restaurant', 'user', 'reports' )
                         ->get();

        return view( 'admin.pages.index-reviews', compact( 'reviews' ) );
    }




}
