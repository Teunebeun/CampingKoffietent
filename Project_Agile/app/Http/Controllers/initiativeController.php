<?php

namespace App\Http\Controllers;

use App\ActivityPlanned;
use App\Initiative;
use App\Initiator;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class initiativeController extends Controller
{

    public function show()
    {
        $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())
            ->where('existing_activity_id', '!=', 1)
            ->orWhere('id', '=', 1)
            ->orderBy('start_datetime')
            ->paginate(2, ['*'], 'upcomingPagination');
        $finishedActivities = ActivityPlanned::whereDate('start_datetime', '<', Carbon::now())
            ->orderBy('start_datetime', 'desc')
            ->paginate(2, ['*'], 'finishedPagination');
        $vacanciesWihtoutActivity = Vacancy::whereNull('activity_planned_id')
            ->where('is_open', '=', true)
            ->paginate(4, ['*'], 'vacanciesWihtoutActivity');

        $upcomingActivities = $this->checkIfActivityHasOpenVacancy($upcomingActivities);

        return view('initiative/initiative', [
            'upcomingActivities' => $upcomingActivities,
            'finishedActivities' => $finishedActivities,
            'vacanciesWihtoutActivity' => $vacanciesWihtoutActivity,
        ]);
    }

    public function searchWithFilter()
    {
        switch (request()->input('action')) {
            case 'searchByText':
                if (request('searchText') == "") {
                    $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())
                        ->where('existing_activity_id', '!=', 1)
                        ->orWhere('id', '=', 1)
                        ->orderBy('start_datetime')
                        ->paginate(2, ['*'], 'upcomingPagination');
                } else {
                    $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())
                        ->where(function ($query) {
                            $query->where('name', "LIKE", '%' . request('searchText') . '%');
                            $query->orWhere('description', "LIKE", '%' . request('searchText') . '%');
                        })
                        ->orderBy('start_datetime')
                        ->paginate(2, ['*'], 'upcomingPagination');
                }
                break;

            case 'searchByDate':
                if (request('searchDate') == "") {
                    $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())->paginate(2, ['*'], 'upcomingPagination');
                } else{
                  $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())
                    ->whereDate('start_datetime', '=', request('searchDate'))
                    ->orderBy('start_datetime')
                    ->paginate(2, ['*'], 'upcomingPagination');
                }
                break;
            default:
                $upcomingActivities = ActivityPlanned::whereDate('start_datetime', '>=', Carbon::now())
                    ->paginate(2, ['*'], 'upcomingPagination');
        }

        $finishedActivities = ActivityPlanned::whereDate('start_datetime', '<', Carbon::now())
            ->orderBy('start_datetime', 'desc')
            ->paginate(2, ['*'], 'finishedPagination');
        $vacanciesWihtoutActivity = Vacancy::whereNull('activity_planned_id')
            ->where('is_open', '=', true)
            ->paginate(4, ['*'], 'vacanciesWihtoutActivity');

        $upcomingActivities = $this->checkIfActivityHasOpenVacancy($upcomingActivities);

        return view('initiative/initiative', [
            'upcomingActivities' => $upcomingActivities,
            'finishedActivities' => $finishedActivities,
            'vacanciesWihtoutActivity' => $vacanciesWihtoutActivity,
        ]);
    }

    private function checkIfActivityHasOpenVacancy($upcomingActivities)
    {
        foreach ($upcomingActivities as $activity) {
            $full = true;

            if ($activity->vacancies) {
                foreach ($activity->vacancies as $vacancy) {
                    if (!$vacancy->vacancy_filled && $vacancy->is_open) {
                        $full = false;
                    }
                }
            }
            $activity->filled = $full;
        }
        return $upcomingActivities;
    }

    public function create()
    {
        return view('initiative/createInitiative');

    }

    private function findInitiator(Request $req)
    {
        $initiator = Initiator::all()->where("name", $req->name)->where('middlename', $req->middlename)->where('lastname', $req->lastname)->first();

        return $initiator;
    }

    public function store()
    {
        $rules = [
            'name' => ['required', 'max:45'],
            'middlename' => ['max:45'],
            'lastname' => ['required', 'max:45'],
            'email' => 'E-mail',
            'phonenumber' => 'digits:10',
            'title' => ['required', 'max:45'],
            'description' => 'required',
        ];

        $messages = [
            'e_mail' => 'Dit is geen geldig email addres',
            'digits' => 'Dit is geen geldig telefoonnummer',
            'max' => 'Dit zijn te veel woorden',
        ];
        $this->validate(request(), $rules, $messages);

        $initiator = $this->findInitiator(request());

        if ($initiator === null) {
            $init = new Initiator();

            $init->name = request('name');
            $init->middlename = request('middlename');
            $init->lastname = request('lastname');
            $init->email = request('email');
            $init->phonenumber = request('phonenumber');
            $init->save();

            $initiator = $init;
        }

        $initiative = new Initiative();

        $initiative->initiator_id = $initiator->id;
        $initiative->title = request('title');
        $initiative->description = request('description');
        $initiative->datetime = now();
        $initiative->seen = 0;

        $initiative->save();

        return view('initiative/successInitiative');

    }
}
