<?php

namespace App\Http\Controllers\cms;

use App\Activity;
use App\ActivityPlanned;
use App\Application;
use App\Campingbaas;
use App\Http\Controllers\Controller;
use App\User;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;

class CMSVacancyController extends Controller
{
    const PAGINATE_NR = 5;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vacancies = request('searchVacancy') ? Vacancy::where('title', "LIKE", '%' . request('searchVacancy') . '%')->orWhere('description', "LIKE", '%' . request('searchVacancy') . '%')->get() : Vacancy::all();
        $vacancies = $vacancies->sortBy('start_datetime')->filter(
            function($vacancy) {
                return !$vacancy->is_deleted;
            }
        );

        $applications = request('searchApplication') ? Application::filter(Application::all(), request('searchApplication')) : Application::all();
        $applications = $applications->sortBy('datetime')->filter(
            function($application) {
                return !$application->is_accepted;
            }
        );

        $vacancies = $this->paginate($vacancies, 'vacanciesPage');
        $applications = $this->paginate($applications, 'applicationsPage');

        return view('/cms/vacancy/index', [
            "vacancies" => $vacancies,
            "applications" => $applications
        ]);
    }

    public function create()
    {
        return view("/cms/vacancy/create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:45'],
            'description' => ['required', 'string', 'max:600'],
            'startDate' => ['nullable', 'after:today', 'date'],
            'startTime' => ['nullable', 'date_format:H:i'],
            'endTime' => ['nullable', 'date_format:H:i', 'after:startTime'],
            'picture' => ['image', 'max:2048'],
            'people_amount_required' => ['required', 'digits_between:1,10']
        ], [
            'startDate.after' => 'De startdatum moet in de toekomst gezet worden.',
            'endTime.after' => 'De eindtijd mag niet voor de starttijd plaatsvinden.'
        ]);

        // get correct date format
        $startDate = $endDate = null;
        if ($request->get('startDate') != null) {
            $startDate = $request->get('startTime') != null ? Carbon::createFromFormat('Y-m-d H:i', $request->get('startDate') . ' ' . $request->get('startTime'))->toDateTimeString() : null;
            $endDate = $request->get('endTime') != null ? Carbon::createFromFormat('Y-m-d H:i', $request->get('startDate') . ' ' . $request->get('endTime'))->toDateTimeString() : null;
        }

        // upload image
        $avatarName = null;
        if ($request->hasFile('picture')) {
            $date = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $avatarName = 'img/vacancy/' . $date . '.' . $request->picture->getClientOriginalExtension();
            $request->file('picture')->move(public_path('img/vacancy'), $avatarName);
        }

        $vacancy = new Vacancy([
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'start_datetime' => $startDate,
            'end_datetime' => $endDate,
            'picture' => $avatarName,
            'people_amount_required' => $request->get('people_amount_required'),
            'vacancy_filled' => false,
            'is_deleted' => false,
            'is_open' => true,
        ]);

        $vacancy->save();
        return redirect(route('cms-vacancy'));
    }

    public function show($id)
    {
        $application = Application::findOrFail($id);
        $vacancy = Vacancy::findOrFail($application->vacancy_id);

        $application->seen = 1;
        $application->save();

        return view('/cms/vacancy/application', [
            'vacancy' => $vacancy, 'application' => $application
        ]);
    }

    public function edit($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        return view('/cms/vacancy/edit', compact('vacancy'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:45'],
            'description' => ['required', 'string', 'max:600'],
            'startDate' => ['nullable', 'date'],
            'startTime' => ['nullable', 'date_format:H:i'],
            'endTime' => ['nullable', 'date_format:H:i', 'after:startTime'],
            'picture' => ['image', 'max:2048'],
            'people_amount_required' => ['required', 'digits_between:1,10']
        ], [
            'endTime.after' => 'De eindtijd mag niet voor de starttijd plaatsvinden.'
        ]);

        $vacancy = Vacancy::findOrFail($id);

        // get correct date format
        $startDate = $endDate = null;
        if ($request->get('startDate') != null) {
            $startDate = $request->get('startTime') != null ? Carbon::createFromFormat('Y-m-d H:i', $request->get('startDate') . ' ' . $request->get('startTime'))->toDateTimeString() : null;
            $endDate = $request->get('endTime') != null ? Carbon::createFromFormat('Y-m-d H:i', $request->get('startDate') . ' ' . $request->get('endTime'))->toDateTimeString() : null;
        }

        // upload image
        $avatarName = $vacancy->picture;
        if ($request->hasFile('picture')) {
            if ($avatarName) {
                if (!$this->isImageUsed($avatarName, $vacancy->id)) {
                    if (File::exists(public_path($avatarName))) {
                        File::delete(public_path($avatarName));
                    }
                }
            }
            $date = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $avatarName = 'img/vacancy/' . $date . '.' . $request->picture->getClientOriginalExtension();
            $request->file('picture')->move(public_path('img/vacancy'), $avatarName);;
        }

        $vacancy->title = $request->get('title');
        $vacancy->description = $request->get('description');
        $vacancy->start_datetime = $startDate;
        $vacancy->end_datetime = $endDate;
        $vacancy->picture = $avatarName;
        $vacancy->is_open = $request->get('is_open') === 'true' ? true : false;
        $vacancy->people_amount_required = $request->get('people_amount_required');

        $vacancy->save();
        return redirect(route('cms-vacancy'));
    }

    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->is_deleted = true;
        $vacancy->is_open = false;

        // Soft Delete
        if ($vacancy->picture) {
            if (!$this->isImageUsed($vacancy->picture, $vacancy->id)) {
                if (File::exists(public_path($vacancy->picture))) {
                    File::delete(public_path($vacancy->picture));
                }
            }
        }
        $vacancy->picture = null;

        $vacancy->save();
        return redirect(route('cms-vacancy'));
    }

    public function destroyApplication($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();
        return redirect(route('cms-vacancy'));
    }

    public function acceptApplication($id)
    {
        $application = Application::findOrFail($id);
        $vacancy = $application->vacancy;

        if ($vacancy->is_deleted) {
            return redirect('/cms/vacancy/application/' . $id)
                ->withErrors("Je kan niet inplannen op een verwijderde vacature.");
        }

        if ($application->is_accepted) {
            return redirect('/cms/vacancy/application/' . $id)
                ->withErrors("Deze aanmelding is al geaccepteerd.");
        }

        $campingbaas = $this->checkForExistingCampingbaas($application);

        if ($campingbaas->planned_activities()->where('id', $vacancy->activity_planned_id)->exists()) {
            return redirect('/cms/vacancy/application/' . $id)
                ->withErrors("Deze campingbaas is al ingepland voor dit initiatief.");
        }

        if ($vacancy->activity_planned_id != null) {
            $campingbaas->planned_activities()->attach($vacancy->activity);
        }

        $application->is_accepted = true;
        $application->save();

        if ($vacancy->getAcceptedPeopleAmount() == $vacancy->people_amount_required) {
            $vacancy->vacancy_filled = true;
            $vacancy->is_open = false;
            $vacancy->save();
        }

        return redirect(route('cms-vacancy'));
    }

    // checks if campingbaas with name of applicant exists, creates new campingbaas if not.
    private function checkForExistingCampingbaas($application)
    {
        $result = Campingbaas::where('firstname', '=', $application->firstname)
            ->where('lastname', '=', $application->lastname)
            ->where('email', '=', $application->email)
            ->first();

        if ($result == null) {
            $result = new Campingbaas();
            $result->firstname = $application->firstname;
            $result->middlename = $application->middlename;
            $result->lastname = $application->lastname;
            $result->email = $application->email;
            $result->phonenumber = $application->phonenumber;
            $result->description = null;
            $result->picture_big = null;
            $result->picture_small = null;
            $result->save();
        }
        return $result;
    }

    protected function isImageUsed($imgPath, $ownId)
    {
        if (Activity::where('picture', '=', $imgPath)->exists()
            || ActivityPlanned::where('display_picture', '=', $imgPath)->exists()
            || Vacancy::where('picture', '=', $imgPath)->where('id', '!=', $ownId)->exists()) {
            return true;
        }
        return false;
    }

    public function paginate($items, $pageName)
    {
        $perPage = self::PAGINATE_NR;
        $options = [];
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $paginator->setPageName($pageName);
        $paginator->setPath('/' . request()->path());

        return $paginator;
    }
}
