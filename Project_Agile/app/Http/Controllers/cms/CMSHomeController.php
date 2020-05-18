<?php

namespace App\Http\Controllers\cms;

use App\ActivityPlanned;
use App\Application;
use App\Donation;
use App\Http\Controllers\Controller;
use App\Initiative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CMSHomeController extends Controller
{
    public function show()
    {
        $todays_activities = ActivityPlanned::whereDate('start_datetime', today())
            ->orderBY('start_datetime', 'asc')
            ->take(3)
            ->get();

        $tomorrows_activities = ActivityPlanned::whereDate('start_datetime', date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))))
            ->orderBy('start_datetime', 'asc')
            ->take(3)
            ->get();

        $last_added = ActivityPlanned::orderBy('creation_datetime', 'desc')
            ->take(3)
            ->get();

        $recent_donations = Donation::with(['donationtarget', 'donationtarget.activityplanned'])
            ->orderBy('donation.datetime', 'desc')
            ->take(3)
            ->get();

        $new_initiatives = Initiative::with('initiator')
            ->where('seen', 0)
            ->orderBy('datetime', 'asc')
            ->paginate(4, ['*'], 'new_initiativesPaginate');

        $new_applications = Application::with('vacancy')
            ->where('seen', '0')
            ->where('is_accepted', '0')
            ->orderBy('datetime', 'asc')
            ->paginate(4, ['*'], 'new_applicationsPaginate');

        return view('/cms/CMSdashboard', [
            'todays_activities' => $todays_activities,
            'tomorrows_activities' => $tomorrows_activities,
            'last_added' => $last_added,
            'recent_donations' => $recent_donations,
            'new_initiatives' => $new_initiatives,
            'new_applications' => $new_applications
        ]);
    }
}
