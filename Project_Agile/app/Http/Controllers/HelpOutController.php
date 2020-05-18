<?php

namespace App\Http\Controllers;

use App\Vacancy;
use Carbon\Carbon;

class HelpOutController extends Controller
{
    public function index()
    {
        $vacancies = Vacancy::whereNotNull('activity_planned_id')->where('is_open', '=', true)->whereDate('start_datetime', '>=', Carbon::now())->orderBy('start_datetime')->paginate(3, ['*'], 'vacancies');
        $vacanciesWithoutActivity = Vacancy::whereNull('activity_planned_id')->where('is_open', '=', true)->orderBy('start_datetime')->paginate(3, ['*'], 'vacanciesWithoutActivity');

        return view('help-out', [
            'vacancies' => $vacancies,
            'vacanciesWithoutActivity' => $vacanciesWithoutActivity
        ]);
    }

    public function searchWithFilter()
    {
        switch (request()->input('action')) {
            case 'searchByText':
                if (request('searchText') == "") {
                    $vacancies = Vacancy::whereNotNull('activity_planned_id')->where('is_open', '=', true)->whereDate('start_datetime', '>=', Carbon::now())->orderBy('start_datetime')->paginate(3, ['*'], 'vacancies');
                } else {
                    $vacancies = Vacancy::whereNotNull('activity_planned_id')
                        ->where('is_open', '=', true)
                        ->whereDate('start_datetime', '>=', Carbon::now())
                        ->where(function($query){
                            $query->where('title', "LIKE", '%' . request('searchText') . '%');
                            $query->orWhere('description', "LIKE", '%' . request('searchText') . '%');
                        })
                        ->orderBy('start_datetime')
                        ->paginate(3, ['*'], 'vacancies');
                }
                break;

            case 'searchByDate':
                if (request('searchDate') == "") {
                    $vacancies = Vacancy::whereNotNull('activity_planned_id')->where('is_open', '=', true)->whereDate('start_datetime', '>=', Carbon::now())->paginate(3, ['*'], 'vacancies');
                } else{
                    $vacancies = Vacancy::whereNotNull('activity_planned_id')
                    ->where('is_open', '=', true)
                    ->whereDate('start_datetime', '>=', Carbon::now())
                    ->whereDate('start_datetime', '=', request('searchDate'))
                    ->orderBy('start_datetime')
                    ->paginate(3, ['*'], 'vacancies');
                }

                break;
            default:
                $vacancies = Vacancy::whereNotNull('activity_planned_id')->where('is_open', '=', true)->whereDate('start_datetime', '>=', Carbon::now())->paginate(3, ['*'], 'vacancies');
        }

        $vacanciesWithoutActivity = Vacancy::whereNull('activity_planned_id')->where('is_open', '=', true)->orderBy('start_datetime')->paginate(3, ['*'], 'vacanciesWithoutActivity');

        return view('help-out', [
            'vacancies' => $vacancies,
            'vacanciesWithoutActivity' => $vacanciesWithoutActivity
        ]);
    }
}
