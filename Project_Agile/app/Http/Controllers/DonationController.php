<?php

namespace App\Http\Controllers;

use App\ActivityPlanned;
use App\Donation;
use App\DonationTarget;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    //<editor-fold desc="Used for a product donation">
    public function createProduct($id = null)
    {
        $this->checkParam($id);

        $donationTarget = DonationTarget::select('id', 'donation_item', 'donation_received', 'title', 'description', 'Activity_Planned_id', 'donation_needed')->where('id', '=', $id)->get();

        if($donationTarget->first() === null || $donationTarget->first()->is_completed === true){
            return redirect(route('home'));
        }

        $activity = ActivityPlanned::select('start_datetime', 'name', 'display_picture', 'end_datetime')->where('id', '=', $donationTarget->first()->Activity_Planned_id)->get();


        return view('donation/DonationProduct', [
            'donationTarget' => $donationTarget->first(),
            'activity' => $activity->first()
        ]);

    }

    public function storeProduct(Request $request){

        $rules = [
            'amount' => ['required', 'integer', 'between:0,10000'],
            'firstname' => ['required', 'string', 'max:45'],
            'middlename' => ['string', 'nullable', 'max:45'],
            'lastname' => ['required', 'string', 'max:45'],
            'phonenumber' => ['required', 'digits:10'],
            'email' => ['required', 'string', 'email', 'max:60'],
            'reason' => ['required', 'max:255'],
        ];

        $messages = [
            'required' => 'Dit veld moet ingevuld zijn',
            'integer' => 'Dit veld moet uit nummers bestaan',
            'digits' => 'Dit veld moet 10 nummers bevatten (06123...)',
            'e_mail' => 'Dit is geen geldig email addres',
            'max' => 'Dit zijn te veel woorden',
        ];
        $this->validate($request, $rules, $messages);

        $donation = new Donation();

        $donation->Donation_Target_id = $request->id;
        $donation->donator_name = $request->firstname;
        $donation->donator_middlename = $request->middlename;
        $donation->donator_lastname = $request->lastname;
        $donation->description = $request->reason;
        $donation->donation_amount = $request->amount;
        $donation->donator_email = $request->email;
        $donation->donator_phonenumber = $request->phonenumber;
        $donation->status = "Ingevoerd";
        $donation->datetime = Carbon::now()->toDateTimeString();
        $donation->is_received = 0;

        $donation->save();

        return redirect(route('donation-received'));
    }
    //</editor-fold>


    //<editor-fold desc="Used for a regular money donation, this one isn't tied to an activity_planned">
    public function createNormal()
    {
        return view("donation/DonationNormal");
    }

    // storeNormal is the same as storeMoney

    //</editor-fold>


    //<editor-fold desc="Used for a money donation, this one IS tied to an activity_planned">
    public function createMoney($id = null)
    {
        $this->checkParam($id);
        $donationTarget = DonationTarget::select('id', 'donation_received', 'title', 'description', 'Activity_Planned_id')->where('id', '=', $id)->get();

        if($donationTarget->first() === null || $donationTarget->first()->is_completed === true){
            return redirect(route('home'));
        }

        $activity = ActivityPlanned::select('start_datetime', 'name', 'display_picture', 'end_datetime')->where('id', '=', $donationTarget->first()->Activity_Planned_id)->get();


        return view('donation/DonationMoney', [
            'donationTarget' => $donationTarget->first(),
            'activity' => $activity->first()
        ]);


    }

    public function storeMoney(Request $request){
        $rules = [
            'amount' => ['required','regex:/^\d+(\.\d{1,2})?$/', 'numeric','between:0.01,10000.00'],
            'reason' => ['required', 'max:255'],
            'firstname' => ['max:40'],
            'middlename' => ['max:40'],
            'lastname' => ['max:40'],
        ];

        $messages = [
            'required' => 'Dit veld moet ingevuld zijn',
            'between' => 'Dit bedrag is onjuist',
            'max' => 'Dit zijn teveel karakters',
            'regex' => 'Dit is geen geldig bedrag',
        ];
        $this->validate($request, $rules, $messages);

        $donation = new Donation();

        $donation->Donation_Target_id = $request->id ?? 1;
        $donation->description = $request->reason;
        $donation->donation_amount = $request->amount;
        $donation->datetime = Carbon::now()->toDateTimeString();
        $donation->status = "In process";
        $donation->is_received = 0;

        // Explicitly define e-mail and phonenumber as null, so that 'null' can be encrypted (Since this field is automatically encrypted).
        $donation->donator_email = null;
        $donation->donator_phonenumber = null;

        if($request->anom!=="on") {
            $donation->donator_name = $request->firstname;
            $donation->donator_middlename = $request->midlename;
            $donation->donator_lastname = $request->lastname;
        } else {
            $donation->donator_name = null;
            $donation->donator_middlename = null;
            $donation->donator_lastname = null;
        }

        // TODO MOLLYPAY

        // TODO: Onderstaand codeblok alleen uitvoeren wanneer donatie succesvol afgehandeld is via MollyPay, anders doorgaan naar $donation->save()
        $donation->is_received = 1;
        $donation->donationtarget->donation_received += $donation->donation_amount;
        $donation->donationtarget->save();

        $donation->save();

        return redirect(route('donation-received'));
    }
    //</editor-fold>


    //<editor-fold desc="Used for the DonationOverview page">

    public function showOverview(){

        $activities = DonationTarget::where('donation_target.is_completed', '=', false)
            ->join('activity_planned' ,'donation_target.Activity_Planned_id', '=', 'activity_planned.id', 'left outer')
            ->select("donation_target.title", "donation_target.description", "donation_target.is_completed", "donation_target.donation_needed", "donation_target.donation_received", "activity_planned.start_datetime",
                "activity_planned.end_datetime", "activity_planned.name", "activity_planned.display_picture", "activity_planned.id as apid", 'donation_target.id as dtid', "donation_target.donation_item")
            ->where(function($query){
                $query->where('start_datetime', '>=', Carbon::now()->toDateString())
                    ->orWhere('start_datetime', '=', null);
            })
            ->orderBy(DB::raw('start_datetime IS NULL'))
            ->orderBy('start_datetime', 'asc')
            ->paginate(4, ['*'], 'paginate');

        return view("donation/DonationOverview", [
            "donationTarget" => $activities
        ]);
    }

    public function showOverviewFilter(Request $req){
        // zoeken op category
        if($req->searchText === null){
            if($req->searchType === "Euro"){
                $activities = DonationTarget::where('donation_target.is_completed', '=', false)
                    ->join('activity_planned' ,'donation_target.Activity_planned_id', '=', 'activity_planned.id', 'left outer')
                    ->select("donation_target.title", "donation_target.description", "donation_target.is_completed", "donation_target.donation_needed", "donation_target.donation_received", "activity_planned.start_datetime",
                        "activity_planned.end_datetime", "activity_planned.name", "activity_planned.display_picture", "activity_planned.id as apid", 'donation_target.id as dtid', "donation_target.donation_item")

                    ->where('donation_item', '=', "Euro")
                    ->where(function($query){
                        $query->where('start_datetime', '>=', Carbon::now()->toDateString())
                            ->orWhere('start_datetime', '=', null);
                    })
                    ->orderBy(DB::raw('start_datetime IS NULL'))
                    ->orderBy('start_datetime', 'asc')
                    ->paginate(4, ['*'], 'paginate');

            }else if($req->searchType==="Product"){
                $activities = DonationTarget::where('donation_target.is_completed', '=', false)
                    ->join('activity_planned' ,'donation_target.Activity_planned_id', '=', 'activity_planned.id', 'left outer')
                    ->select("donation_target.title", "donation_target.description", "donation_target.is_completed", "donation_target.donation_needed", "donation_target.donation_received", "activity_planned.start_datetime",
                        "activity_planned.end_datetime", "activity_planned.name", "activity_planned.display_picture", "activity_planned.id as apid", 'donation_target.id as dtid', "donation_target.donation_item")
                    ->where(function($query){
                        $query->where('start_datetime', '>=', Carbon::now()->toDateString())
                            ->orWhere('start_datetime', '=', null);
                    })
                    ->orderBy(DB::raw('start_datetime IS NULL'))
                    ->orderBy('start_datetime', 'asc')
                    ->where('donation_target.donation_item', '<>', "Euro")
                    ->paginate(4, ['*'], 'paginate');

            }else{
                return redirect(route('donation-overview'));
            }
        }
        // zoeken op text
        else{
            $activities = DonationTarget::where('donation_target.is_completed', '=', false)
                ->join('activity_planned' ,'donation_target.Activity_planned_id', '=', 'activity_planned.id', 'left outer')
                ->select("donation_target.title", "donation_target.description", "donation_target.is_completed", "donation_target.donation_needed", "donation_target.donation_received", "activity_planned.start_datetime",
                    "activity_planned.end_datetime", "activity_planned.name", "activity_planned.display_picture", "activity_planned.id as apid", 'donation_target.id as dtid', "donation_target.donation_item")
                ->where(function($query){
                    $query->where('donation_target.title', 'LIKE', '%'. request('searchText'). '%')
                        ->orWhere('donation_target.description', 'LIKE', '%' . request('searchText'). '%');
                })
                ->where(function($query){
                    $query->where('start_datetime', '>=', Carbon::now()->toDateString())
                        ->orWhere('start_datetime', '=', null);
                })
                ->orderBy(DB::raw('start_datetime IS NULL'))
                ->orderBy('start_datetime', 'asc')
                ->paginate(4, ['*'], 'paginate');
        }

        return view("donation/DonationOverview", [
            "donationTarget" => $activities
        ]);
    }

    //</editor-fold>


    //<editor-fold desc="Thank you page">

    public function showReceived(){
        return view('donation/DonationReceived');
    }

    //</editor-fold>


    //<editor-fold desc="helpers">
    private function checkParam($id = null){
        if($id === null){
            return redirect(route('home'));
        }
    }

    private function MollyPay(){
        // TODO: create mollypay object and return it
    }
    //</editor-fold>

}
