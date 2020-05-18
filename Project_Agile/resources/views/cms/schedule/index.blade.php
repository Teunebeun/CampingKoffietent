@extends('layouts.cms')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/schedule.css') }}">
@endsection

@section('page-title')
    Rooster
@endsection

@section('content')
    <div id="schedule_container">
        <div id="upperrow">
            <span class="arrowkey left">
                <a href="{{route('cms-schedule-yeardate', [$date->startOfMonth()->submonth()->year,$date->monthName])}}">
                    <
                </a>
            </span>
            {{ $monthnameDutch }} {{$date->year}}
            <span class="arrowkey right">
                <a href="{{route('cms-schedule-yeardate', [$date->startOfMonth()->addmonth()->addmonth()->year,$date->monthName])}}">
                    >
                </a>
            </span>
            <br />
        </div>
        <div class="days_container">
            @foreach($array = array("Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag", "Zondag") as $dag)
                <div class="dayname">
                    <span>{{$dag}}</span>
                </div>
            @endforeach
        </div>
        <div id="bottom_row_container">
            @foreach($schedule as $day)
                <div class="day {{ $day["month"] != $monthnameEnglish ? 'grey' : '' }}">
                    <div class="day_info">
                        <a href="{{route('schedule-create', [$day['date']])}}">
                            <span>+</span>
                            <h3>{{$day["number"]}}</h3>
                        </a>
                    </div>
                    <div class="activity_container">
                        @if($day["activity"] != null)
                            @foreach($day["activity"] as $activity)

                                <a href="{{route('schedule-edit', [$activity['id']])}}">
                                    <div class="day_activities_container {{$activity["color"]}}">

                                        <div class="day_activities">
                                            <span class="activity_info">
                                                {{$activity["name"]}} <br />
                                                {{$activity["starttime"]->format("H:i")}} - {{$activity['endtime']===null ? '' : $activity["endtime"]->format("H:i")}}</span><br />
                                            @foreach($activity["campingbazen"] as $baas)
                                                <span class="activity_info">{{$baas["name"]}}</span>
                                            @endforeach
                                        </div>

                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="day_no_activities" style="background-color: white; border:0">
                                <p>geen initiatieven</p>
                            </div>
                        @endif
                        </div>
                </div>
            @endforeach
        </div>
        <div id="caption_container">
            <div id="caption_wrapper">
                <h2>Legenda: </h2>
                <div class="caption_row">
                    <p>Alles geregeld</p>
                    <div class="caption_color green"></div>
                </div>
                <div class="caption_row">
                    <p>Openstaande aanmelding</p>
                    <div class="caption_color orange"></div>
                </div>
                <div class="caption_row">
                    <p>Geen campingbazen</p>
                    <div class="caption_color red"></div>
                </div>
                <h2><a href="#">Exporteer agenda</a></h2>
            </div>
        </div>
    </div>
@endsection
