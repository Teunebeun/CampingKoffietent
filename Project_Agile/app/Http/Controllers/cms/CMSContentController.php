<?php

namespace App\Http\Controllers\cms;

use App\FooterLink;
use App\SingularItems;
use App\ActivityPlanned;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CMSContentController extends Controller
{
    const OPENING_HOURS_REGEX = '/^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$/m';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('cms.content.index');
    }

    public function editHomepage()
    {
        $singularItems = SingularItems::firstOrFail();
        return view('cms.content.edit.homepage', compact('singularItems'));
    }

    public function updateHomepage(Request $request)
    {
        $request->validate([
            'homepage_title' => ['required', 'string', 'max:45'],
            'homepage_picture' => ['image', 'max:2048'],
            'homepage_text' => ['required', 'string', 'max:1000'],
            'coffee_title' => ['required', 'string', 'max:45'],
            'activity_title' => ['required', 'string', 'max:45'],
            'help_title' => ['required', 'string', 'max:45'],
            'donate_title' => ['required', 'string', 'max:45'],
            'coffee_picture' => ['image', 'max:2048'],
            'activity_picture' => ['image', 'max:2048'],
            'help_picture' => ['image', 'max:2048'],
            'donate_picture' => ['image', 'max:2048'],
            'coffee_text' => ['required', 'string', 'max:1000'],
            'activity_text' => ['required', 'string', 'max:1000'],
            'help_text' => ['required', 'string', 'max:1000'],
            'donate_text' => ['required', 'string', 'max:1000'],
            'coffee_button' => ['required', 'string', 'max:45'],
            'activity_button' => ['required', 'string', 'max:45'],
            'help_button' => ['required', 'string', 'max:45'],
            'donate_button' => ['required', 'string', 'max:45'],
        ],
        [
            'max' => 'De tekst mag niet meer dan :max karakters bevatten!',
            'required' => 'Dit veld is verplicht!',
            'string' => 'Dit veld moet een stuk tekst zijn!',
            'image' => 'Het bestand moet een afbeelding zijn!'
        ]);

        $singularItems = SingularItems::firstOrFail();

        $singularItems->homepage_title = request('homepage_title');
        $singularItems->homepage_picture = $this->handlePicture($request, $singularItems->homepage_picture, '/img/singularItem/', 'homepage_picture');
        $singularItems->homepage_text = request('homepage_text');
        $singularItems->coffee_title = request('coffee_title');
        $singularItems->activity_title = request('activity_title');
        $singularItems->help_title = request('help_title');
        $singularItems->donate_title = request('donate_title');
        $singularItems->coffee_picture = $this->handlePicture($request, $singularItems->coffee_picture, '/img/singularItem/', 'coffee_picture');
        $singularItems->activity_picture = $this->handlePicture($request, $singularItems->activity_picture, '/img/singularItem/', 'activity_picture');
        $singularItems->help_picture = $this->handlePicture($request, $singularItems->help_picture, '/img/singularItem/', 'help_picture');
        $singularItems->donate_picture = $this->handlePicture($request, $singularItems->donate_picture, '/img/singularItem/', 'donate_picture');
        $singularItems->coffee_text = request('coffee_text');
        $singularItems->activity_text = request('activity_text');
        $singularItems->help_text = request('help_text');
        $singularItems->donate_text = request('donate_text');
        $singularItems->coffee_button = request('coffee_button');
        $singularItems->activity_button = request('activity_button');
        $singularItems->help_button = request('help_button');
        $singularItems->donate_button = request('donate_button');

        $singularItems->save();

        return redirect('/cms/content')->with('success', 'Hoofdpagina gewijzigd!');;
    }

    public function editInitiative()
    {
        $activity = ActivityPlanned::findOrFail(1);
        return view('cms.content.edit.initiative', compact('activity'));
    }

    public function updateInitiative(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'display_picture' => ['image', 'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
        ],
        [
            'name.required' => 'Je moet het initiatief een naam geven!',
            'name.string' => 'De naam moet een stuk tekst zijn!',
            'name.max' => 'De naam mag maximaal 45 karakters bevatten!',
            'display_picture.image' => 'Het bestand moet een afbeelding zijn!',
            'display_picture.max' => 'De naam van de afbeelding mag maximaal 2048 karakters bevatten!',
            'description.required' => 'De beschrijving mag niet leeg zijn!',
            'description.string' => 'De beschrijving moet een stuk tekst zijn!',
            'description.max' => 'De beschrijving mag maximaal 1000 karakters bevatten!'
        ]);

        $activity = ActivityPlanned::findOrFail(1);

        $activity->name = request('name');
        $activity->display_picture = $this->handlePicture($request, $activity->display_picture, '/img/activityDisplayPicture/', 'display_picture');
        $activity->description = request('name');

        $activity->save();

        return redirect('/cms/content')->with('success', 'Initiatieven pagina gewijzigd!');;
    }

    public function editContact()
    {
        $singularItems = SingularItems::firstOrFail();
        return view('cms.content.edit.contact', compact('singularItems'));
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contactpage_text' => ['required', 'string', 'max:1000'],
        ],
        [
            'contactpage_text.required' => 'De inleidende tekst mag niet leeg zijn!',
            'contactpage_text.string' => 'De inleidende tekst moet een stuk tekst zijn!',
            'contactpage_text.max' => 'De inleidende tekst mag maximaal 1000 karakters bevatten!'
        ]);

        $singularItems = SingularItems::firstOrFail();

        $singularItems->contactpage_text = $request->get('contactpage_text');
        $singularItems->save();

        return redirect('/cms/content')->with('success', 'Contactpagina gewijzigd!');;
    }

    public function editOpeningHours()
    {
        $singularItems = SingularItems::firstOrFail();
        return view('cms.content.edit.opening-hours', compact('singularItems'));
    }

    public function updateOpeningHours(Request $request)
    {
        $request->validate([
            'opentime_monday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'opentime_tuesday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'opentime_wednesday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'opentime_thursday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'opentime_friday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'opentime_saturday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'opentime_sunday' => array(
                'nullable',
                'regex:' . self::OPENING_HOURS_REGEX,
            ),
            'location_link' => ['required', 'max:500', 'url'],
        ],
        [
            'regex' => 'De tekst voldoet niet aan de gevraagde indeling!',
            'max' => 'De tekst mag niet meer dan :max karakters bevatten!',
            'required' => 'Dit veld is verplicht!',
            'url' => 'De link moet in deze vorm zijn: https://www.weeshuisjes.nl',
        ]);

        $singularItems = SingularItems::firstOrFail();

        $singularItems->opentime_monday = $request->get('opentime_monday');
        $singularItems->opentime_tuesday = $request->get('opentime_tuesday');
        $singularItems->opentime_wednesday = $request->get('opentime_wednesday');
        $singularItems->opentime_thursday = $request->get('opentime_thursday');
        $singularItems->opentime_friday = $request->get('opentime_friday');
        $singularItems->opentime_saturday = $request->get('opentime_saturday');
        $singularItems->opentime_sunday = $request->get('opentime_sunday');
        $singularItems->location_link = $request->get('location_link');
        $singularItems->save();

        return redirect('/cms/content')->with('success', 'Openingstijden pagina gewijzigd!');;
    }

    public function editOther()
    {
        $singularItems = SingularItems::firstOrFail();
        $footerLinks = FooterLink::all();
        return view('cms.content.edit.other', compact(['singularItems', 'footerLinks']));
    }

    public function updateOther(Request $request)
    {
        $request->validate([
            'homepage_logo' => ['image', 'max:2048'],
            'otherSitesName.*' => ['required', 'max:60'],
            'otherSitesLink.*' => ['required', 'max:200', 'url'],
            'adres_street' => ['required', 'max:50'],
            'adres_place' => ['required', 'max:50'],
            'facebook_link' => ['required', 'max:200', 'url'],
            'instagram_link' => ['required', 'max:200', 'url'],
            'twitter_link' => ['required', 'max:200', 'url'],
            'email_link' => ['required', 'max:200'],
        ],
        [
            'max' => 'De tekst mag niet meer dan :max karakters bevatten!',
            'required' => 'Dit veld is verplicht!',
            'otherSitesLink.*' => 'De link moet in deze vorm: https://www.weeshuisjes.nl'
        ]);

        $singularItems = SingularItems::firstOrFail();

        $this->handleOtherSites();
        $singularItems->homepage_logo = $this->handlePicture($request, $singularItems->homepage_logo, '/img/singularItem/', 'homepage_logo');
        $singularItems->adres_street = request('adres_street');
        $singularItems->adres_place = request('adres_place');
        $singularItems->facebook_link = request('facebook_link');
        $singularItems->instagram_link = request('instagram_link');
        $singularItems->twitter_link = request('twitter_link');
        $singularItems->email_link = request('email_link');
        $singularItems->save();

        return redirect('/cms/content')->with('success', 'Overige is gewijzigd!');;
    }

    private function handleOtherSites()
    {
        FooterLink::truncate();

        $linkNames = request('otherSitesName');
        $links = request('otherSitesLink');

        if ($linkNames == null) return;

        for ($i = 0; $i < count($linkNames); $i++){
            $link = new FooterLink([
                'name' => $linkNames[$i],
                'link' => $links[$i]
            ]);

            $link->save();
        }
    }

    public function handlePicture($request, $pictureName, $path, $name)
    {
        $newPictureName = null;
        if ($request->hasFile($name)) {
            if (File::exists(public_path($pictureName))) {
                File::delete(public_path($pictureName));
            }
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', $name . Carbon::now());
            $newPictureName = $path . $date . '.' . $request->$name->getClientOriginalExtension();
            $request->file($name)->move(public_path($path), $newPictureName);
        } else {
            $newPictureName = $pictureName;
        }

        return $newPictureName;
    }
}
