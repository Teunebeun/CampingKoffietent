<?php

namespace App\Http\Controllers\cms;

use App\Http\Controllers\Controller;
use App\Sponsor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CMSSponsorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('/cms/sponsor/index', ['sponsors' => Sponsor::all()]);
    }

    public function create()
    {
        return view("/cms/sponsor/create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'logo' => ['required', 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
            'link' => ['required', 'url', 'max:200']
        ],
            [
                'name.required' => 'Je moet een naam geven!',
                'name.string' => 'De naam moet een stuk tekst zijn!',
                'name.max' => 'De naam mag maximaal 45 karakters bevatten!',
                'logo.required' => 'Je moet een afbeelding kiezen!',
                'logo.image' => 'Het bestand moet een afbeelding zijn!',
                'logo.max' => 'De naam van de afbeelding mag maximaal 2048 karakters bevatten!',
                'description.required' => 'De beschrijving mag niet leeg zijn!',
                'description.string' => 'De beschrijving moet een stuk tekst zijn!',
                'description.max' => 'De beschrijving mag maximaal 1000 karakters bevatten!',
                'link.required' => 'Je moet een link geven!',
                'link.url' => 'De link moet in deze vorm: https://www.weeshuisjes.nl',
                'link.max' => 'De link mag maximaal 200 karakters bevatten!'
            ]);

        $pictureName = null;
        if ($request->hasFile('logo')) {
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $pictureName = 'img/sponsor/' . $date . '.' . $request->logo->getClientOriginalExtension();
            $request->file('logo')->move(public_path('img/sponsor'), $pictureName);
        }

        $sponsor = new Sponsor([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'logo' => $pictureName,
            'link' => $request->get('link')
        ]);

        $sponsor->save();
        return redirect('/cms/sponsor');
    }

    public function edit($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        return view("/cms/sponsor/edit", ['sponsor' => $sponsor]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'logo' => ['sometimes', 'image', 'max:2048'],
            'description' => ['required', 'string', 'max:1000'],
            'link' => ['required', 'url', 'max:200']
        ],
            [
                'name.required' => 'Je moet een naam geven!',
                'name.string' => 'De naam moet een stuk tekst zijn!',
                'name.max' => 'De naam mag maximaal 45 karakters bevatten!',
                'logo.image' => 'Het bestand moet een afbeelding zijn!',
                'logo.max' => 'De naam van de afbeelding mag maximaal 2048 karakters bevatten!',
                'description.required' => 'De beschrijving mag niet leeg zijn!',
                'description.string' => 'De beschrijving moet een stuk tekst zijn!',
                'description.max' => 'De beschrijving mag maximaal 1000 karakters bevatten!',
                'link.required' => 'Je moet een link geven!',
                'link.url' => 'De link moet in deze vorm: https://www.weeshuisjes.nl',
                'link.max' => 'De link mag maximaal 200 karakters bevatten!'
            ]);

        $sponsor = Sponsor::findOrFail($id);

        $pictureName = null;
        if ($request->hasFile('logo')) {
            if (File::exists(public_path($sponsor->logo))) {
                File::delete(public_path($sponsor->logo));
            }
            $date = $cleanStr = preg_replace('/[^A-Za-z0-9]/', '', Carbon::now());
            $pictureName = 'img/sponsor/' . $date . '.' . $request->logo->getClientOriginalExtension();
            $request->file('logo')->move(public_path('img/sponsor'), $pictureName);
        } else {
            $pictureName = $sponsor->logo;
        }

        $sponsor->name = $request->get('name');
        $sponsor->description = $request->get('description');
        $sponsor->logo = $pictureName;
        $sponsor->link = $request->get('link');
        $sponsor->save();

        return redirect('/cms/sponsor');
    }

    public function destroy($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        if (File::exists(public_path($sponsor->logo))) {
            File::delete(public_path($sponsor->logo));
        }
        $sponsor->delete();
        return redirect('/cms/sponsor');
    }
}
