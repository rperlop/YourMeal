<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller {
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $reports = Report::all();

        return view( 'reports.index', compact( 'reports' ) );
    }

    public function show( $id ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $report = Report::find( $id );

        return view( 'reports.show', compact( 'report' ) );
    }

    public function create( Review $review ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        return view( '/report', compact( 'review' ) );
    }

    public function store( Request $request ) {
        $validator = Validator::make( $request->all(), [
            'reason' => 'required|max:1500',
        ], [
            'first_name.required' => 'The reason is mandatory.',
            'first_name.max'      => 'The reason can not have more than 1500 characters.',
        ] );

        if ( $validator->fails() ) {
            return back()->withErrors( $validator )
                         ->withInput();
        }

        $report = new Report();
        $report->user_id = auth()->user()->id;
        $report->review_id = $request->review_id;
        $report->reason = $request->reason;
        $restaurant = $request->restaurant_id;
        $report->save();

        return redirect( '/restaurant/'. $restaurant )->with('success', 'Report submitted successfully.');

    }

    public function destroy( $id ): Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse {
        $report = Report::find( $id );
        $report->delete();

        return redirect( '/reports' );
    }
}
