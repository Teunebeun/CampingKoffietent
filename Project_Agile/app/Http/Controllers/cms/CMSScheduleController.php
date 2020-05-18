<?php

namespace App\Http\Controllers\cms;

use App\Activity;
use App\ActivityPicture;
use App\ActivityPlanned;
use App\Application;
use App\Campingbaas;
use App\DonationTarget;
use App\Http\Controllers\Controller;
use App\Vacancy;
use App\Translate;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

class CMSScheduleController extends Controller
{

    public function index()
    {
        return $this->showSchedule(Carbon::now()->year, Carbon::now()->monthName);
    }

    public function exportimg()
    {
        $params = http_build_query(array(
            "access_key" => "05690d6538164a6dbb925d7c32fd1941",
            "url" => "http://localhost/Weeshuisjes-M/Project_Agile/public/index.php/rooster/index/2020/April",
            "fresh" => "true",
            "full_page" => "true",
        ));

        $image_data = file_get_contents("https://api.apiflash.com/v1/urltoimage?" . $params);

        //https://www.quora.com/Is-there-a-screenshot-API-that-can-work-with-logged-in-websites
        //TODO: to test with Authenticator

        $image_data = file_get_contents('full_screenshot.jpeg');

        $im = imagecreatefromstring($image_data);
        $image_result = imagecrop($im, ['x' => 650, 'y' => 1050, 'width' => 1200, 'height' => 600]);

        ob_start();
        imagejpeg($image_result);
        $content = ob_get_contents();
        ob_end_clean();

        $response = new Response(
            $content,
            Response::HTTP_OK,
            ['Content-Disposition' => 'attachment',
                'Content-Type' => 'image/png',
                'filename' => 'screenshot.png']
        );

        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            "screenshot.png"
        );

        $response->headers->set('Content-Disposition', $disposition);

        $response->send();
    }

    public function showyeardate($year, $date)
    {
        $translate = new Translate();
        if ($year > 3000 || $year < 2000 || $year === null) {
            $year = Carbon::now()->year;
        }

        if ($date === null || !$translate->DoesMonthExists($date)) {
            $date = Carbon::now()->monthName;
        }
        return $this->showSchedule($year, $date);
    }

    private function showSchedule($year, $month)
    {

        $date = Carbon::createFromFormat("Y-M", $year . "-" . $month);
        if ($date->monthName != $month) {
            $date = $date->subMonth();
        }
        $first = $date->startOfMonth();
        $last = $date->startOfMonth();

        $firstday = new Carbon("last monday of" . $first->subMonth()->monthName . $date->year);
        $lastday = new Carbon("first sunday of " . $first->addMonth()->addMonth()->monthName . " " . $date->year);

        $period = CarbonPeriod::between($firstday, $lastday);

        $activities = ActivityPlanned::selectRaw("id, DATE(start_datetime) as date, start_datetime, end_datetime, description, display_picture , name")
            ->whereBetween('start_datetime', [$firstday, $lastday])
            ->orderBy('start_datetime', 'asc')
            ->get();
        $schedule = array();

        foreach ($period as $item) {
            //DAY
            $day = array();
            $day["dayname"] = substr($item->dayName, 0, 2);
            $day["number"] = $item->day;
            $day["month"] = $item->monthName;
            $day["activity"] = array();
            $day['date'] = $item->format('yy-m-d');

            $amount = count(array_keys(array_column($activities->toArray(), 'date'), $item->format('Y-m-d')));
            if ($amount > 0) {
                $index = array_search(
                    $item->format('Y-m-d'),
                    array_column($activities->toArray(), 'date'));
                for ($i = 0; $i < $amount; $i++) {
                    //ACTIVITY
                    $activity = array();
                    $activity["name"] = $activities[$index]->name;
                    $activity["id"] = $activities[$index]->id;
                    $activity["starttime"] = $activities[$index]->start_datetime;
                    $activity["endtime"] = $activities[$index]->end_datetime;

                    //CAMPINGBAZEN
                    $activity["campingbazen"] = array();
                    if ($activities[$index]->campingbazen()->count() > 0) {
                        foreach ($activities[$index]->campingbazen as $cbs) {
                            $campingbaas = array();
                            $campingbaas["name"] = $cbs->firstname;

                            array_push($activity["campingbazen"], $campingbaas);
                        }
                        if ($activities[$index]->vacancies->first() != null && $activities[$index]->vacancies->first()->openApplicationAmount() > 0) {
                            $activity["color"] = "orange";
                        } else {
                            $activity["color"] = "green";
                        }
                    } else {
                        $activity["color"] = "red";
                    }

                    array_push($day["activity"], $activity);
                    $index = $index + 1;

                    if (!isset($activities[$index], $activities) || $activities[$index]->date != $item->format('Y-m-d')) {
                        break;
                    }
                }
            }
            array_push($schedule, $day);
        }
        $translate = new Translate();
        $last = $last->subMonth();
        return view("/cms/schedule.index", [
            "schedule" => $schedule,
            "monthnameDutch" => $translate->TranslateMonthToDutch($last->monthName),
            "monthnameEnglish" => $last->monthName,
            "date" => $last
        ]);
    }

    public function create($date = null)
    {
        $activities = Activity::get();
        $campingbazen = Campingbaas::get();

        $defaultdate = $date;

        return view('/cms/schedule.create', [
            'activities' => $activities,
            'campingbazen' => $campingbazen,
            "defaultdate" => $defaultdate,
        ]);
    }

    public function store()
    {
        //region Validation
        $this->transformIntoJson();
        $this->validatePlannedActivity();

        if (request('is-repeated') == 'on') {
            $this->validateRepeat();

        }
        if (request('selectedCampingbaasAnswer') != null) {
            $this->validateCampingbaasActivityPlanned();
        }
        if (request('title') != null || request('number') != null || request('details') != null) {
            $this->validateVacancy();
        }
        if (request('donation-items') != null) {
            $this->validateDonations();
        }
        //endregion

        //region Repeat Planned Activity
        if (request('is-repeated') == 'on') {
            $oldDate = Carbon::createFromDate(request('date'));
            $this->addSingleActivityPlanned($oldDate->format('Y-m-d'));
            for ($i = 0; $i < request('repeatAmount'); $i++) {
                $oldDate = $oldDate->addWeek();
                $this->addSingleActivityPlanned($oldDate->format('Y-m-d'));
            }
        } else {
            $this->addSingleActivityPlanned(request('date'));
        }
        //endregion

        return redirect(route('cms-schedule-home'));
    }

    private function addSingleActivityPlanned($formdate)
    {
        //region Activity Planned
        $activityplanned = new ActivityPlanned();
        $activityplanned->existing_activity_id = request('selectedInitiativeAnswer')['id'];

        $startdatetime = Carbon::createFromFormat('Y-m-d H:i', $formdate . ' ' . request('starttime'))->toDateTimeString();
        $activityplanned->start_datetime = $startdatetime;

        if (request('endtime') != null) {
            $enddatetime = Carbon::createFromFormat('Y-m-d H:i', $formdate . ' ' . request('endtime'))->toDateTimeString();
            $activityplanned->end_datetime = $enddatetime;
        } else {
            $activityplanned->end_datetime = null;
        }

        $activityplanned->name = request('activityName');
        $activityplanned->description = request('activityDetails');

        $activity = Activity::findorfail(request('selectedInitiativeAnswer')['id']);
        $activityplanned->display_picture = $activity->picture;

        if (request('activityImage') != null) {
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $pictureName = '/img/activityDisplayPicture/' . $date . '.' . request('activityImage')->getClientOriginalExtension();
            request('activityImage')->move(public_path('img/activityDisplayPicture'), $pictureName);
            $activityplanned->display_picture = $pictureName;
        } else {
            $activity = Activity::findorfail(request('selectedInitiativeAnswer')['id']);
            $activityplanned->display_picture = $activity->picture;
        }

        $activityplanned->save();
        //endregion

        //region Campingbaas Activity Planned
        if (request('selectedCampingbaasAnswer') != null) {
            foreach (request('selectedCampingbaasAnswer') as $baas) {
                $activityplanned->campingbazen()->attach($baas['id']);
            }
        }
        //endregion

        //region Vacancy
        if (request('title') != null || request('number') != null || request('details') != null) {
            $vacancy = new Vacancy();
            $vacancy->activity_planned_id = $activityplanned->id;
            $vacancy->title = request('title');
            $vacancy->description = request('details');
            $vacancy->people_amount_required = request('number');
            $vacancy->vacancy_filled = 0;
            $vacancy->is_deleted = 0;

            $vacancy->start_datetime = $activityplanned->start_datetime;
            if ($activityplanned->end_datetime != null) {
                $vacancy->end_datetime = $activityplanned->end_datetime;
            }
            $vacancy->picture = $activityplanned->display_picture;

            $vacancy->save();
        }
        //endregion

        //region Donations
        if (request('donation-items') != null) {
            foreach (request('donation-items') as $don) {
                $donation = new DonationTarget();
                $donation->activity_planned_id = $activityplanned->id;
                $donation->donation_item = $don['donation-item'];
                $donation->donation_needed = (double)$don['donation-amount'];
                $donation->donation_received = 0;
                $donation->title = $don['donation-title'];
                $donation->description = $don['donation-details'];
                $donation->datetime = Carbon::now()->toDateTimeString();
                $donation->is_completed = $don['donation-amount'] == null;

                $donation->save();
            }
        }
        //endregion
    }

    public function edit($id)
    {
        $activities = Activity::get();
        $campingbazen = Campingbaas::get()->map(function($item, $key) {
            return [
                'id' => $item->id,
                'firstname' => $item->firstname,
                'middlename' => $item->middlename,
                'lastname' => $item->lastname
            ];
        });

        $activityplanned = ActivityPlanned::findorfail($id);
        $vacancy = Vacancy::where('activity_planned_id', $id)->first();

        $donations = DonationTarget::where('activity_planned_id', $id)->get();
        // due to naming conflicts
        $donationresult = array();
        foreach ($donations as $don) {
            $donitem = array();

            $donitem['donationID'] = $don->id;
            $donitem['donation-title'] = $don->title;
            $donitem['donation-item'] = $don->donation_item;
            $donitem['donation-amount'] = $don->donation_needed;
            $donitem['donation-received'] = $don->donation_received;
            $donitem['donation-details'] = $don->description;

            array_push($donationresult, $donitem);
        }

        return view("/cms/schedule.edit", [
            'activities' => $activities,
            'campingbazen' => $campingbazen,
            'activityplanned' => $activityplanned,
            'vacancy' => $vacancy,
            'donations' => $donationresult,
        ]);
    }

    public function update($id)
    {
        //region Validation

        $this->transformIntoJson();
        $this->validatePlannedActivity();
        $this->validatePictures();

        if (request('selectedCampingbaasAnswer') != null) {
            $this->validateCampingbaasActivityPlanned();
        }
        if (request('title') != null || request('number') != null || request('details') != null) {
            $this->validateVacancy();
        }
        if (request('selectedApplicationAnswer') != null) {
            $this->validateApplication();
        }
        if (request('donation-items') != null) {
            $this->validateDonations();
        }
        //endregion

        //region Activity Planned
        $activityplanned = ActivityPlanned::findorfail($id);
        $activityplanned->existing_activity_id = request('selectedInitiativeAnswer')['id'];

        $startdatetime = Carbon::createFromFormat('Y-m-d H:i', request('date') . ' ' . request('starttime'))->toDateTimeString();
        $activityplanned->start_datetime = $startdatetime;

        if (request('endtime') != null) {
            $enddatetime = Carbon::createFromFormat('Y-m-d H:i', request('date') . ' ' . request('endtime'))->toDateTimeString();
            $activityplanned->end_datetime = $enddatetime;
        } else {
            $activityplanned->end_datetime = null;
        }

        $activityplanned->name = request('activityName');
        $activityplanned->description = request('activityDetails');
        $activity = Activity::findorfail(request('selectedInitiativeAnswer')['id']);

        if (request('activityImage') != null) {
            if (!$this->isImageUsed($activityplanned->display_picture, $activityplanned->id)) {
                if (File::exists(public_path($activityplanned->display_picture))) {
                    File::delete(public_path($activityplanned->display_picture));
                }
            }
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $pictureName = '/img/activityDisplayPicture/' . $date . '.' . request('activityImage')->getClientOriginalExtension();
            request('activityImage')->move(public_path('img/activityDisplayPicture'), $pictureName);
            $activityplanned->display_picture = $pictureName;

        }

        $activityplanned->save();
        //endregion

        //region Campingbaas Activity Planned
        $activityplanned->campingbazen()->detach();
        if (request('selectedCampingbaasAnswer') != null) {
            foreach (request('selectedCampingbaasAnswer') as $baas) {
                $activityplanned->campingbazen()->attach($baas['id']);
            }
        }
        //endregion

        //region Vacancy
        if (request('title') != null || request('number') != null || request('details') != null) {
            $vacancy = Vacancy::firstorNew(['activity_planned_id' => $id]);
            $vacancy->activity_planned_id = $activityplanned->id;
            $vacancy->title = request('title');
            $vacancy->description = request('details');
            $vacancy->people_amount_required = request('number');
            $vacancy->vacancy_filled = $vacancy->applicationAmount() == request('number') ? 1 : 0;
            $vacancy->is_deleted = false;
            $vacancy->is_open = request('is_open') == true ? 1 : 0;

            $vacancy->start_datetime = $activityplanned->start_datetime;
            if ($activityplanned->end_datetime != null) {
                $vacancy->end_datetime = $activityplanned->end_datetime;
            }

            $vacancy->save();
        }
        //endregion

        //region Donations
        $currentDonationID = DonationTarget::where('activity_planned_id', '=', $activityplanned->id)->pluck('id')->toArray();

        if (request('donation-items') != null) {
            foreach (request('donation-items') as $don) {
                if (is_numeric($don['donationID'])) {
                    $currentDonationID = array_diff($currentDonationID, [((int)$don['donationID'])]);

                    $donation = DonationTarget::findorfail($don['donationID']);
                    $donation->activity_planned_id = $activityplanned->id;
                    $donation->donation_item = $don['donation-item'];
                    $donation->donation_needed = (double)$don['donation-amount'];
                    $donation->title = $don['donation-title'];
                    $donation->description = $don['donation-details'];
                    $donation->is_completed = $don['donation-amount'] >= $donation->donation_received;
                } else {
                    $donation = new DonationTarget();
                    $donation->activity_planned_id = $activityplanned->id;
                    $donation->donation_item = $don['donation-item'];
                    $donation->donation_needed = (double)$don['donation-amount'];
                    $donation->donation_received = 0;
                    $donation->title = $don['donation-title'];
                    $donation->description = $don['donation-details'];
                    $donation->datetime = Carbon::now()->toDateTimeString();
                    $donation->is_completed = $don['donation-amount'] == null;
                }
                $donation->save();
            }
        }
        if ($currentDonationID) {
            foreach ($currentDonationID as $curID) {
                DonationTarget::findorfail($curID)->delete();
            }
        }
        //endregion

        //region Applications
        if (request('selectedApplicationAnswer') != null) {
            foreach (request('selectedApplicationAnswer') as $app) {
                $existingApp = Application::findorfail($app['id']);
                $campingbaas = $this->checkForExistingCampingbaas($existingApp);

                $existingApp->seen = 1;
                $existingApp->is_accepted = 1;

                $existingApp->save();
                $campingbaas->save();

                $activityplanned->campingbazen()->attach($campingbaas['id']);
            }
        }
        //endregion

        //region Pictures
        foreach ($activityplanned->activityPictures as $oldPic) {
            if (request('old-pictures') == null || !in_array($oldPic->picture, request('old-pictures'))) {
                if (File::exists(public_path($oldPic->picture))) {
                    File::delete(public_path($oldPic->picture));
                }
                $oldPic->delete();
            }
        }

        if (request('pictures') != null) {
            foreach (request('pictures') as $pic) {
                $activityPicture = ActivityPicture::create(["picture" => $pic->getClientOriginalName(), "Activity_Planned_id" => $activityplanned->id]);
                $activityPicture->picture = '/img/activity/' . $activityPicture->id . '-' . $pic->getClientOriginalName();
                $activityPicture->save();

                $pic->move(public_path('img/activity'), $activityPicture->picture);
            }
        }
        //endregion

        return redirect(route('cms-schedule-home'));
    }

    public function destroy($id)
    {
        $activityplanned = ActivityPlanned::findorfail($id);
        $activityplanned->campingbazen()->detach();

        $vacancy = Vacancy::find(['activity_planned_id' => $id])->first();
        if ($vacancy != null) {
            $vacancy->activity_planned_id = null;
            $vacancy->save();
        }

        if (!$this->isImageUsed($activityplanned->display_picture, $activityplanned->id)) {
            if (File::exists(public_path($activityplanned->display_picture))) {
                File::delete(public_path($activityplanned->display_picture));
            }
        }

        $activityplanned->delete();

        return redirect(route('cms-schedule-home'));
    }

    protected function isImageUsed($imgPath, $ownId)
    {
        if (Activity::where('picture', '=', $imgPath)->exists()
            || ActivityPlanned::where('display_picture', '=', $imgPath)->where('id', '!=', $ownId)->exists()
            || Vacancy::where('picture', '=', $imgPath)->exists()) {
            return true;
        }
        return false;
    }

    protected function transformIntoJson()
    {
        if (request('selectedInitiativeAnswer') != null) {
            $iniAnswer['selectedInitiativeAnswer'] = json_decode(request('selectedInitiativeAnswer'), true);
            request()->merge($iniAnswer);
        }

        if (request('selectedCampingbaasAnswer') != null) {

            $campAnswer['selectedCampingbaasAnswer'] = array();
            foreach (request('selectedCampingbaasAnswer') as $camp) {
                $result = json_decode($camp, true);
                array_push($campAnswer['selectedCampingbaasAnswer'], $result);
            }
            request()->merge($campAnswer);
        }

        if (request('donation-items') != null) {
            $donAnswer['donation-items'] = array();
            foreach (request('donation-items') as $don) {
                $result = json_decode($don, true);
                array_push($donAnswer['donation-items'], $result);
            }
            request()->merge($donAnswer);
        }
    }

    protected function validatePlannedActivity()
    {
        return request()->validate([
            'date' => 'required|date',
            'starttime' => 'required|date_format:"H:i"',
            'endtime' => 'nullable|date_format:"H:i"|after:starttime',
            'activityName' => 'required|max:45',
            'activityImage' => 'nullable|image|max:2048',
            'activityDetails' => 'required|string|max:1000',
            'selectedInitiativeAnswer' => 'required',
        ], [
            'date.required' => 'De datum kan niet leeg zijn',
            'date.date' => 'Datum is niet geldig',
            'starttime.required' => 'Starttijd moet ingevuld zijn',
            'starttime.date_format' => 'Geef de tijd op als 12:00',
            'endtime.date_format' => 'Geef de tijd op als 12:00',
            'endtime.after' => 'De eindtijd kan niet voor de startijd zijn',
            'activityName.required' => 'Het initiatief moet een naam hebben',
            'activityName.max' => 'De naam van het initiatief mag maar maximaal 45 characters zijn',
            'activityImage.image' => 'Het bestand moet een afbeelding zijn',
            'activityImage.max' => 'De naam van de afbeelding mag maximaal 2048 karakters bevatten!',
            'activityDetails.required' => 'De beschrijving is verplicht',
            'activityDetails.string' => 'De beschrijving moet tekst zijn',
            'activityDetails.max' => 'De beschrijving mag maar maximaal 1000 characters zijn',
            'selectedInitiativeAnswer.required' => 'Er moet een initiatief geselecteerd zijn',
        ]);
    }

    protected function validateCampingbaasActivityPlanned()
    {
        return request()->validate([
            'selectedCampingbaasAnswer' => 'required',
        ]);
    }

    protected function validateVacancy()
    {
        return request()->validate([
            'title' => 'required|string|max:45',
            'number' => 'required|integer|between:1,10',
            'details' => 'required|string|max:600'
        ], [
            'title.required' => 'De titel van de vacature moet ingevuld zijn',
            'title.string' => 'De titel moet bestaan uit 1 of meerdere woorden',
            'title.max' => 'De titel van de vacature mag maar maximaal 45 characters zijn',
            'number.required' => 'Aantal moet ingevuld zijn',
            'number.integer' => 'Aantal moet een geldig getal zijn',
            'number.between' => 'Aantal moet tussen de 1 en 10 zijn',
            'details.required' => 'De beschrijving moet ingevuld zijn',
            'details.string' => 'De beschrijving moet bestaan uit 1 of meerdere woorden',
            'details.max' => 'De beschrijving mag maar maximaal 600 characters zijn'
        ]);
    }

    protected function validateApplication()
    {
        $appAnswer['selectedApplicationAnswer'] = array();

        foreach (request('selectedApplicationAnswer') as $app) {
            $result = json_decode($app, true);
            array_push($appAnswer['selectedApplicationAnswer'], $result);
        }
        request()->merge($appAnswer);

        return request()->validate([
            'selectedApplicationAnswer' => 'required',
        ]);
    }

    protected function validatePictures()
    {
        return request()->validate([
            'pictures.*' => ['nullable', 'image', 'max:2048'],
            'old-picutres.*' => ['nullable', 'image', 'max:2048']
        ],
            ['pictures.*.max' => 'De afbeelding mag max 2mb zijn!']
            );
    }

    private function validateDonations()
    {
        return request()->validate([
            'donation-items.*.donation-title' => 'required|string|max:45',
            'donation-items.*.donation-item' => 'required|string|max:45',
            'donation-items.*.donation-amount' => 'nullable|integer|between:0,99999999',
            'donation-items.*.donation-details' => 'required|string|max:255',
        ], [
            'donation-items.*.donation-title.required' => 'De titel van een donatie moet ingevuld zijn',
            'donation-items.*.donation-title.string' => 'De titel van een donatie moet bestaan uit 1 of meerdere woorden',
            'donation-items.*.donation-title.max' => 'De titel van een donatie mag maar maximaal 45 characters zijn',
            'donation-items.*.donation-item.required' => 'Het voorwerp van een donatie moet ingevuld zijn',
            'donation-items.*.donation-item.string' => 'Het voorwerp van een donatie moet bestaan uit 1 of meerdere woorden',
            'donation-items.*.donation-item.max' => 'Het voorwerp van een donatie mag maar maximaal 45 characters zijn',
            'donation-items.*.donation-amount.integer' => 'Het aantal van een donatie moet een geldig getal zijn',
            'donation-items.*.donation-amount.between' => 'Het aantal van een donatie moet tussen de 0 en 99999999 zijn',
            'donation-items.*.donation-details.required' => 'De beschrijving van een donatie moet ingevuld zijn',
            'donation-items.*.donation-details.string' => 'De beschrijving van een donatie moet bestaan uit 1 of meerdere woorden',
            'donation-items.*.donation-details.max' => 'De beschrijving van een donatie mag maar maximaal 255 characters zijn',
        ]);
    }

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
            $result->save();
        }
        return $result;
    }

    private function validateRepeat()
    {
        return request()->validate([
            'is-repeated' => 'accepted',
            'repeatAmount' => 'required',
        ]);
    }
}
