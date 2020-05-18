<?php

namespace  App\Http\Controllers;

use App\Translate;
use App\SingularItems;
use Carbon\Carbon;

class OpeningHoursController extends Controller{

    public function show(){
        $dates = $this->GetDatesThisWeek();
        $data = SingularItems::first();
        $currentDate = Carbon::now()->dayOfWeek;
        
        return view('openingshours',[
            'data' => $data,
            'dates' => $dates,
            'currentDate' => $currentDate
        ]);
        
    }

    public function GetDatesThisWeek()
    {
        $translate = new Translate();
        $dates = [];
        $orderedDates = [];
        $dates[0] = Carbon::now();
        
        for ($i=1; $i < 7; $i++) { 
            $dates[$i] = Carbon::now()->addDays($i);
        }

        foreach ($dates as $date) {
            $orderedDates[$date->dayOfWeekIso] = $date->day . " " .$translate->TranslateMonthToDutch($dates[0]->monthName);
        }

        return $orderedDates;
    }
}
