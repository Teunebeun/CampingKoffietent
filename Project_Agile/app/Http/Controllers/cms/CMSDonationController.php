<?php

namespace App\Http\Controllers\cms;

use App\Donation;
use App\DonationTarget;
use App\Http\Requests\DonationTargetRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CMSDonationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request) {
        $donations = Donation::all()->where('is_received', '=', 0);
        if(request()->input('search_donators')) {
            $donations = Donation::filter($donations, request('search_donators'));
        }

        return view('cms.donations.index', [
            'donationTargets' => request()->input('search_requests') ? $this->paginate(DonationTarget::filter(DonationTarget::all(), request('search_requests')), 'requestPage') : $this->paginate(DonationTarget::all(), 'requestPage'),
            'donations' => $this->paginate($donations->map(function($item, $key) {
                return [
                    'id' => $item->id,
                    'targetId' => $item->donationtarget->id,
                    'fullName' => $item->donator_name !== null ? $item->donator_name .' '. $item->donator_middlename .' '. $item->donator_lastname : 'Anoniem',
                    'description' => $item->donationtarget->title,
                ];
            }), 'donationPage')
        ]);
    }

    public function showDonation(Donation $donation) {
        return view('cms.donations.donations.show', [
                'donation' => $donation
            ]
        );
    }

    public function acceptDonation(Donation $donation) {
        $donation->is_received = 1;
        $donation->donationtarget->donation_received += $donation->donation_amount;
        $donation->donationtarget->update();
        $donation->update();

        return redirect()->route('donations.index');
    }

    public function create() {
        return view('cms.donations.donationRequests.create');
    }

    public function store(DonationTargetRequest $request) {
        $request->validated();

        $donationRequest = new DonationTarget();
        $donationRequest->title = $request->title;
        $donationRequest->donation_item = $request->donation_item;
        $donationRequest->donation_needed = $request->donation_needed;
        $donationRequest->description = $request->description;
        $donationRequest->save();

        return redirect()->route('donations.index');
    }

    public function edit(Request $request, DonationTarget $donationRequest) {
        $donations = null;
        if(request()->input('search_donators')) {
            $donations = Donation::filter($donationRequest->donation, request('search_donators'));
        } else {
            $donations = $donationRequest->donation;
        }
        return view('cms.donations.donationRequests.edit', [
                'donationTarget' => $donationRequest,
                'donations' => $this->paginate($donations->map(function($item, $key) {
                    return [
                        'id' => $item->id,
                        'fullName' => $item->donator_name !== null ? $item->donator_name .' '. $item->donator_middlename .' '. $item->donator_lastname : 'Anoniem',
                        'date' => $item->datetime,
                        'amount' => $item->donation_amount,
                        'received' => $item->is_received
                    ];
                }), 'donatorPage')
            ]
        );
    }

    public function update(DonationTargetRequest $request, DonationTarget $donationRequest) {
        $request->validated();

        $donationRequest->title = $request->title;
        $donationRequest->donation_item = $request->donation_item;
        $donationRequest->donation_needed = $request->donation_needed;
        $donationRequest->description = $request->description;

        $donationRequest->update();

        return redirect()->route('donations.index');
    }

    public function destroyDonation(Donation $donation) {
        try {
            $donation->delete();
        } catch (\Exception $e) {
            dd($e);
            error_log($e);
        }

        return redirect()->route('donations.index');
    }

    public function destroyRequest(DonationTarget $donationRequest) {
        try {
            $donationRequest->delete();
        } catch (\Exception $e) {
            dd($e);
            error_log($e);
        }

        return redirect()->route('donations.index');
    }

    /*
     * Basically pagination for Eloquent collections instead of MySQL resultsets.
     * This allows for correct working of pagination even if collections are filtered in the Donation and DonationTarget models
     */
    public function paginate($items, $pageName)
    {
        $perPage = 5;
        $options = [];
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);
        $paginator = new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
        $paginator->setPageName($pageName);
        $paginator->setPath('/' . request()->path());

        return $paginator;
    }
}
