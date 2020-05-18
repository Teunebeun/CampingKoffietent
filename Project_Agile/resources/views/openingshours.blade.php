@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/OpeningHours.css') }}">
@endsection

@section('content')
    <div class="row">
        <div id="times-div" class="blue-div">
            <p class="div-header bold">Openingstijden</p>
            <p class="medium-text">Openingstijden aankomende 7 dagen</p>
            <table class="small-text table">
                <tr>
                    <th class="table-day"></th>
                    <th></th>
                </tr>
                <tr>
                    <td style="margin-right: 20px "><p class="{{$currentDate == 1 ? 'bold' : ''}}">Ma {{$dates[1]}}:</p></td>
                    <td>
                        @if($data->opentime_monday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_monday}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><p class="{{$currentDate == 2 ? 'bold' : ''}}">Di {{$dates[2]}}:</p></td>
                    <td>
                        @if($data->opentime_tuesday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_tuesday}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><p class="{{$currentDate == 3 ? 'bold' : ''}}">Wo {{$dates[3]}}:</p></td>
                    <td>
                        @if($data->opentime_wednesday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_wednesday}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><p class="{{$currentDate == 4 ? 'bold' : ''}}">Do {{$dates[4]}}:</p></td>
                    <td>
                        @if($data->opentime_thursday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_thursday}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><p class="{{$currentDate == 5 ? 'bold' : ''}}">Vr {{$dates[5]}}:</p></td>
                    <td>
                        @if($data->opentime_friday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_friday}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><p class="{{$currentDate == 6 ? 'bold' : ''}}">Za {{$dates[6]}}:</p></td>
                    <td>
                        @if($data->opentime_saturday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_saturday}}</p>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><p class="{{$currentDate == 7 ? 'bold' : ''}}">Zo {{$dates[7]}}:</p></td>
                    <td>
                        @if($data->opentime_sunday == null)
                            <p class="bold">Gesloten</p>
                        @else
                            <p>{{$data->opentime_sunday}}</p>
                        @endif
                    </td>
                </tr>
            </table>

        </div>
        <div id="location-div" class="blue-div">
            <p class="div-header bold">Locatie</p>
            <iframe src="{{$data->location_link}}" id="map" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            <p class="medium-text">{{$data->adres_street}}</p>
            <p class="medium-text">{{$data->adres_place}}</p>
        </div>
    </div>
@endsection
