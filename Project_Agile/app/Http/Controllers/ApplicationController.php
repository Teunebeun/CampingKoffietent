<?php

namespace App\Http\Controllers;

use App\Application;
use App\Campingbaas;
use App\CampingbaasActivityPlanned;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ApplicationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        //todo id activity meegeven.
        $campingbazen = CampingbaasActivityPlanned::where('Activity_planned_id', '=', Vacancy::findOrFail($id)->activity_planned_id)->join('Campingbaas', 'id', '=', 'Campingbaas_id')
            ->select('Campingbaas.*')
            ->get();

        return view('applications.create', [
            'vacancy' => Vacancy::findOrFail($id),
            'campingbazen' => $campingbazen,
            'id' => $id,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        $id = $request->get('id');
        $request->validate([
            'firstname' => ['required', 'string', 'max:45'],
            'middlename' => ['string', 'nullable', 'max:45'],
            'lastname' => ['required', 'string', 'max:45'],
            'phonenumber' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10', 'max:10'],
            'email' => ['required', 'string', 'email', 'max:60'],
            'application_letter' => ['required'],
        ]);

        $application = new Application([
            'vacancy_id' => $id,
            'firstname' => $request->get('firstname'),
            'middlename' => $request->get('middlename'),
            'lastname' => $request->get('lastname'),
            'phonenumber' => $request->get('phonenumber'),
            'email' => $request->get('email'),
            'application_letter' => $request->get('application_letter'),
            'datetime' => Carbon::now(),
            'seen' => false,
            'is_accepted' => false,
        ]);


        $application->save();

        return redirect('/')->with('success', 'Je verzoek is verstuurd!');
    }
}
