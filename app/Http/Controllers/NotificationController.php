<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Notification;
use App\Models\Report;
use App\Models\Review;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class NotificationController extends Controller
{
    /**
     * Index all notifications
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {

        $notifications = Notification::all();
        return view( 'admin.pages.notifications', compact( 'notifications' ) );

    }

    /**
     * Show a notification
     *
     * @param integer $id
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show_notification( int $id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {

        $notification = Notification::find($id);

        $review = Review::with('user', 'images', 'reports')->find($notification->review_id);

        if ($notification->type == 'reported_review'){
            return view('admin.pages.show-notification', compact('review', 'notification'));
        } else {
            $compulsive_number = Config::where('property', 'compulsive_number')->value('value');
            $reports = Report::where('user_id', $notification->user_id)
                             ->where('created_at', '<', $notification->created_at)
                             ->orderBy('created_at', 'desc')
                             ->take($compulsive_number)
                             ->get();
            return view('admin.pages.show-notification', compact('review', 'notification', 'reports'));
        }

    }
}
