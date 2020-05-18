@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Application.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    Aanmelding
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        <br/>
    @endif

    <div class="application-container">
        <div class="application-details-container">
            <div class="label-container">
                <label for="vacancy">Vacature: </label>
                @if(!$vacancy->is_deleted)
                    <p>{{$vacancy->title}} </p>
                @else
                    <p>Verwijderd</p>
                @endif
            </div>

            <div class="label-container">
                <label for="activity">Initiatief: </label>
                @if($vacancy->activity != null)
                    <p>{{$vacancy->activity->name }} </p>
                @else
                    <p>Losstaande vacature</p>
                @endif
            </div>

            <div class="label-container">
                <label for="start_datetime">Startdatum vacature: </label>
                @if(!$vacancy->is_deleted)
                    <p>{{$vacancy->startDateFormatted() ?? '-'}} </p>
                @else
                    <p>-</p>
                @endif
            </div>

            <div class="label-container">
                <label for="start_time">Starttijd vacature: </label>
                @if(!$vacancy->is_deleted)
                    <p>{{$vacancy->start_datetime->format('h:i')}} </p>
                @else
                    <p>-</p>
                @endif
            </div>

            <div class="label-container">
                <label for="end_time">Eindtijd vacature: </label>
                @if(!$vacancy->is_deleted)
                    <p>{{$vacancy->end_datetime->format('h:i')}} </p>
                @else
                    <p>-</p>
                @endif
            </div>

            <div class="label-container">
                <label for="datetime">Datum aanmelding: </label>
                <p>{{date($application->dateFormatted())}} </p>
            </div>

            <div class="label-container">
                <label for="people_needed">Aantal mensen nodig: </label>
                @if(!$vacancy->is_deleted)
                    <p>{{$vacancy->getAcceptedPeopleAmount()}} / {{$vacancy->people_amount_required}}</p>
                @else
                    <p>-</p>
                @endif
            </div>
        </div>

        <div class="vertical-line"></div>

        <div class="application-details-container">
            <div class="label-container">
                <label for="datetime">Naam: </label>
                <p>{{$application->firstname . " " . $application->middlename . " " . $application->lastname}} </p>
            </div>

            <div class="label-container">
                <label for="datetime">E-mail: </label>
                <p>{{$application->email}} </p>
            </div>

            <div class="label-container">
                <label for="datetime">Telefoonnummer: </label>
                <p>{{$application->phonenumber}} </p>
            </div>

            <div class="label-container">
                <label for="datetime">Toelichting: </label>
                <p>{{$application->application_letter}} </p>
            </div>
        </div>
    </div>
    <div class="button-container">
        <form method="post" action="{{ route('cms-vacancyApplication.destroy', $application->id) }}">
            @method('Delete')
            @csrf
            <button class="delete-btn"
                    onclick="return confirm('Weet je zeker dat je deze aanmelding wilt verwijderen?')">Verwijderen
            </button>
        </form>
        <form method="post" action="{{ route('cms-vacancy.acceptApplication', $application->id) }}">
            @csrf
            <button class="regular-btn">Inplannen</button>
        </form>
    </div>
@endsection
