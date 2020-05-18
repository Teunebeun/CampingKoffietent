<?php

namespace App\Http\Controllers;

use App\ActivityPicture;
use App\Campingbaas;
use App\DonationTarget;
use App\Activity;
use App\Http\Controllers\Controller;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use routes;
use App\ActivityPlanned;
use App\SingularItems;

class initiativeDetailsController extends Controller
{
    public function show($id)
    {
        $initiative = ActivityPlanned::Where('id', '=', $id)->first();
        if ($initiative == null || $id == 1) {
            abort(404);
        }
        $pictures = ActivityPicture::Where('Activity_Planned_id', '=', $id)->paginate(3, ['*'], 'pictures');
        $donations = DonationTarget::Where('Activity_Planned_id', '=', $id)->paginate(3, ['*'], 'donations');
        $vacancy = Vacancy::Where('Activity_Planned_id', '=', $id)
            ->whereDate('start_datetime', '>', Carbon::now())
            ->where('vacancy_filled', '=', 0)
            ->where('is_open', '=', 1)
            ->first();
        $activity = Activity::Where('id', '=', $initiative->existing_activity_id)->first();
        $creator = Campingbaas::Where('id', '=', $activity->creator)->first();

        return view('initiative/initiativeDetails', [
            'initiative' => $initiative,
            'vacancy' => $vacancy,
            'pictures' => $pictures,
            'donations' => $donations,
            'creator' => $creator,
        ]);
    }
}
