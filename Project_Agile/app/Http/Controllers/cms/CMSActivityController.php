<?php

namespace App\Http\Controllers\cms;

use App\Activity;
use App\ActivityPlanned;
use App\Campingbaas;
use App\Http\Controllers\Controller;
use App\Initiative;
use App\Initiator;
use App\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CMSActivityController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $activities = Activity::paginate(8);
        foreach ($activities as $activity) {
            $activityPlanned = $activity->activitiesPlanned()->whereDate('start_datetime', '<', Carbon::now())->orderByDesc('start_datetime')->first();

            if ($activityPlanned) {
                $activity->lastPlanned = $activityPlanned->start_datetime;
            } else {
                $activity->lastPlanned = '';
            }

        }
        return view('cms.activities.index', compact('activities'));
    }


    public function create()
    {
        $employees = Campingbaas::get();
        return view('cms.activities.create', [
            'employees' => $employees
        ]);
    }


    public function createAutofill($id)
    {
        $initiative = Initiative::findOrFail($id);
        $initiator = Initiator::where('id','=',$initiative->Initiator_id)->first();

        $isNew = true;
        foreach(Campingbaas::all() as $campingbaas) {
            if($initiative->initiator->email === $campingbaas->email) {
                $isNew = false;
            }
        }

        if ($isNew) {
            $campingbaas = new Campingbaas([
                'firstname' => $initiator->name,
                'middlename' => $initiator->middlename,
                'lastname' => $initiator->lastname,
                'email' => $initiator->email,
                'phonenumber' => $initiator->phonenumber,
                'picture_small' => null,
                'picture_big' => null,
                'description' => null
            ]);

            $campingbaas->save();
        }
        $employees = Campingbaas::get();
        return view('cms.activities.create', [
            'initiative' => $initiative,
            'employees' => $employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'creator' => ['required'],
            'picture' => ['required', 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
        ],
            [
                'name.required' => 'Je moet het initiatief een naam geven!',
                'name.string' => 'De naam moet een stuk tekst zijn!',
                'name.max' => 'De naam mag maximaal 45 karakters bevatten!',
                'creator.required' => 'Een intiatief moet een bedenker hebben!',
                'picture.required' => 'Je moet een afbeelding kiezen!',
                'picture.image' => 'Het bestand moet een afbeelding zijn!',
                'picture.max' => 'De naam van de afbeelding mag maximaal 2048 karakters bevatten!',
                'description.required' => 'De beschrijving mag niet leeg zijn!',
                'description.string' => 'De beschrijving moet een stuk tekst zijn!',
                'description.max' => 'De beschrijving mag maximaal 1000 karakters bevatten!'
            ]);

        $pictureName = null;
        if ($request->hasFile('picture')) {
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $pictureName = 'img/activityDisplayPicture/' . $date . '.' . $request->picture->getClientOriginalExtension();
            $request->file('picture')->move(public_path('img/activityDisplayPicture'), $pictureName);
        }


        $activity = new Activity([
            'name' => $request->get('name'),
            'creator' => $request->get('creator'),
            'description' => $request->get('description'),
            'picture' => $pictureName,
        ]);

        if ($request->get('initiator_id') != null) {
            $initiator = Initiator::findOrFail($request->get('initiator_id'));
            $initiative = Initiative::findOrFail($request->get('initiative_id'));
            $initiative->delete();
        }
        $activity->save();

        return redirect('/cms/initiatieven');
    }


    public function edit($id)
    {
        $employees = Campingbaas::get();
        $activity = Activity::findOrFail($id);
        return view('cms.activities.edit', compact('activity'),[
            'employees' => $employees
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'creator' => ['required'],
            'picture' => ['sometimes', 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
        ],
            [
                'name.required' => 'Je moet het initiatief een naam geven!',
                'name.string' => 'De naam moet een stuk tekst zijn!',
                'name.max' => 'De naam mag maximaal 45 karakters bevatten!',
                'creator.required' => 'Een intiatief moet een bedenker hebben!',
                'picture.image' => 'Het bestand moet een afbeelding zijn!',
                'picture.max' => 'De naam van de afbeelding mag maximaal 2048 karakters bevatten!',
                'description.required' => 'De beschrijving mag niet leeg zijn!',
                'description.string' => 'De beschrijving moet een stuk tekst zijn!',
                'description.max' => 'De beschrijving mag maximaal 1000 karakters bevatten!'
            ]);

        $activity = Activity::findOrFail($id);
        $pictureName = null;
        if ($request->hasFile('picture')) {
            if (!$this->isImageUsed($activity->picture, $activity->id)) {
                if (File::exists(public_path($activity->picture))) {
                    File::delete(public_path($activity->picture));
                }
            }
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $pictureName = 'img/activityDisplayPicture/' . $date . '.' . $request->picture->getClientOriginalExtension();
            $request->file('picture')->move(public_path('img/activityDisplayPicture'), $pictureName);
        } else {
            $pictureName = $activity->picture;
        }

        $activity->name = $request->get('name');
        $activity->creator = $request->get('creator');
        $activity->description = $request->get('description');
        $activity->picture = $pictureName;
        $activity->save();

        return redirect('/cms/initiatieven');
    }


    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        if (!$this->isImageUsed($activity->picture, $id)) {
            if (File::exists(public_path($activity->picture))) {
                File::delete(public_path($activity->picture));
            }
        }

        $activity->delete();

        return redirect('/cms/initiatieven');
    }

    protected function isImageUsed($imgPath, $ownId)
    {
        if (Activity::where('picture', '=', $imgPath)->where('id', '!=', $ownId)->exists()
            || ActivityPlanned::where('display_picture', '=', $imgPath)->exists()
            || Vacancy::where('picture', '=', $imgPath)->exists()) {
            return true;
        }
        return false;
    }
}
