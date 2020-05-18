<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{

    public function index()
    {
        return view('Sponsor.sponsor', [ 'sponsors' => Sponsor::all() ]);
    }
}
