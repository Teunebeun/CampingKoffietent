@extends('layouts.cms')

@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/SendInitiative.css') }}">
@endsection

@section('page-title')
    Ingezonden initiatieven
@endsection

@section('content')
    <a href="{{ url()->previous() }}" id="backarrow"><i class="message fa fa-arrow-left"></i></a>
    <div class="container">
        <div class="left-container">
            <div class="field">
                <label class="bold">Titel:</label>
                <label class="label">{{$initiative->title}}</label>
            </div>
            <div class="field">
                <label class="bold">Datum:</label>
                <label class="label">{{\Carbon\Carbon::parse($initiative->datetime)->format('d-m-Y')}}</label>
            </div>
            <div class="field">
                <label class="bold">Tijdstip:</label>
                <label class="label">{{\Carbon\Carbon::parse($initiative->datetime)->format('G:i')}}</label>
            </div>
            <div class="field">
                <label class="bold">beschrijving:</label>
                <label class="label">{{$initiative->description}}</label>
            </div>
        </div>
        <div class="right-container">
            <div class="field">
                <label class="bold">Naam:</label>
                <label
                    class="label">{{$initiative->initiator->name . ' '. $initiative->initiator->middlename . ' '. $initiative->initiator->lastname}}</label>
            </div>
            <div class="field">
                <label class="bold">E-mail:</label>
                <label class="label">{{$initiative->initiator->email}}</label>
            </div>
            <div class="field">
                <label class="bold">Telefoonnummer:</label>
                <label class="label">{{$initiative->initiator->phonenumber}}</label>
            </div>
        </div>
    </div>
    <form action="{{route('send_initiative.destroy', $initiative->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-btn"
                onclick="return confirm('Weet je zeker dat je dit ingezonden initiatief wilt verwijderen?')">Verwijder
        </button>
    </form>
    <form action="{{ route('activities.createAutofill', $initiative->id) }}">
        <button class="regular-btn">Accepteren</button>
    </form>
@endsection
