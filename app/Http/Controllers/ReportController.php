<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Notification;
use App\Models\Report;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller {
    /**
     * Index all the reports
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $reports = Report::all();

        return view( 'reports.index', compact( 'reports' ) );
    }

    /**
     * Show a report
     *
     * @param integer $id
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show( int $id ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $report = Report::find( $id );

        return view( 'reports.show', compact( 'report' ) );
    }

    /**
     * Redirect to the creation report view
     *
     * @param Review $review
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function get_report_view( Review $review ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        return view( '/report', compact( 'review' ) );
    }

    /**
     * Store a new report
     *
     * @param Request $request
     *
     * @return Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
     */
    public function store( Request $request ): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application {
        $validator = Validator::make( $request->all(), [
            'reason' => 'required|max:1500',
        ], [
            'reason.required' => 'The reason is mandatory.',
            'reason.max'      => 'The reason cannot have more than 1500 characters.',
        ] );

        if ( $validator->fails() ) {
            return back()->withErrors( $validator )
                         ->withInput();
        }

        $report            = new Report();
        $report->user_id   = auth()->user()->id;
        $report->review_id = $request->review_id;
        $report->reason    = $request->reason;
        $restaurant        = $request->restaurant_id;
        $report->save();

        $reports_min_number = Config::where( 'property', 'reports_min_number' )->value( 'value' );
        $review             = Review::find( $request->review_id );
        $user_id            = $review->user_id;

        $unique_user_reports_count = Report::where( 'review_id', $request->review_id )
                                           ->distinct( 'user_id' )
                                           ->count( 'user_id' );

        if ( $unique_user_reports_count == $reports_min_number ) {
            $notification            = new Notification();
            $notification->type      = 'reported_review';
            $notification->review_id = $request->review_id;
            $notification->user_id   = $user_id;
            $notification->save();
        }

        $user_reports_count = Report::where( 'user_id', $report->user_id )
                                    ->where( 'created_at', '>=', now()->subHour() )
                                    ->count();

        $max_reports_per_user = Config::where( 'property', 'compulsive_number' )->value( 'value' );

        if ( $user_reports_count == $max_reports_per_user + 1 ) {
            $notification          = new Notification();
            $notification->type    = 'compulsive_user';
            $notification->user_id = $report->user_id;
            $notification->save();
        }

        toastr()->success( 'Report submitted successfully.' );

        return redirect( '/restaurant/' . $restaurant );
    }

    /**
     * Dismiss a report of a review
     *
     * @param int $report_id
     *
     * @return RedirectResponse
     */
    public function dismiss_report( int $report_id ): RedirectResponse {
        $report = Report::find( $report_id );

        $report->delete();

        toastr()->success( 'Report dismissed.' );

        return redirect()->back();
    }

    /**
     * Dismiss the reports of a review
     *
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function dismiss_reports( int $id ): RedirectResponse {
        $review = Review::find( $id );

        $review->reports()->delete();

        toastr()->success( 'Reports dismissed.' );

        return redirect()->back();
    }
}
