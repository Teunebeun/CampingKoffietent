@extends('layouts.cms')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/schedule-crud.css') }}">
@endsection

@section('page-title')
    Rooster - Initiatief inplannen
@endsection

@section('content')
    <div class="schedule-create-container">
        <form method="POST" action="{{ route('schedule-store') }}" enctype="multipart/form-data">

            <div class="form-container-left">
                @csrf
                <div class="row">
                    <label class="form-label" for="date">Datum:</label>
                    <input class="input-round-border" type="date" name="date" value="{{ $defaultdate ?? old('date') }}"
                           required>
                    <i class="gg-repeat" id="select-repeat" onclick="selectMenu('select-repeat')"></i>
                </div>
                @error('date')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('is-repeated')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('repeatAmount')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="time">Starttijd:</label>
                    <input class="input-round-border" type="time" name="starttime" value="{{ old('starttime') }}"
                           required>
                </div>
                @error('starttime')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="time">Eindtijd:</label>
                    <input class="input-round-border" type="time" name="endtime" value="{{ old('endtime') }}">
                </div>
                @error('endtime')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="initiatief">Initiatief:</label>
                    <label class="@if(old('activityName') == null) null-selected @endif label-text"
                           id="selectedInitiative">{{ old('activityName') ?? "Selecteer een initiatief" }}
                        @if(old('activityName') != null)
                            <a class="gg-pen" href="javascript:void(0)" onclick="selectMenu('select-activityform')"></a>
                        @endif
                    </label>
                    <i class="gg-arrow-right" id="select-initiative"
                       onclick="selectMenu('select-initiative')"></i>
                </div>
                @error('selectedInitiativeAnswer')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('activityName')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('activityImage')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('activityDetails')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row selectedCampingbazen">
                    <label class="form-label" for="campingbazen">Campingbazen:</label>
                    <div class="label-text ">
                        @if(is_array(old('selectedCampingbaasAnswer')))
                            @forelse(old("selectedCampingbaasAnswer") as $camp)
                                <div class="baas" id="{{  'camp-' . $camp['id'] }}">
                                    <a href="javascript:void(0)" onclick="deleteFunction(this)">
                                        <i class="gg-delete"></i>
                                    </a>
                                    <label class="selectedCampingbazen-item">
                                        {{
                                            $camp['firstname']
                                            . ' '
                                            . $camp['middlename']
                                            . ' '
                                            . $camp['lastname']
                                        }}
                                    </label>
                                </div>
                            @empty
                                <label class="null-selected label-text">Voeg een campingbaas toe</label>
                            @endforelse
                        @else
                            <label class="null-selected label-text">Voeg een campingbaas toe</label>
                        @endif
                    </div>
                    <i class="gg-arrow-right" id="select-campingbazen" onclick="selectMenu('select-campingbazen')"></i>
                </div>
                @error('selectedCampingbaasAnswer')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="vacancies">Vacatures:</label>
                    @if(old('title') !== null && old('title') !== '')
                        <label class="label-text" id="vacancy-name">{{ old('title') }}</label>
                    @else
                        <label class="null-selected label-text" id="vacancy-name">Voeg een vacature toe</label>
                    @endif
                    <i class="gg-arrow-right" id="select-vacancy" onclick="selectMenu('select-vacancy')"></i>
                </div>
                @error('title')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('number')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror
                @error('details')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row selectedDonations">
                    <label class="form-label" for="donations">Donaties:</label>
                    <label class="label-text @if(!old('donation-items')) null-selected @endif" id="selectedDonation">
                        Voeg een donatie toe
                        @if(is_array(old('donation-items')))
                            @foreach(old('donation-items') as $donation)
                                <div class="don">
                                    <a href="javascript:void(0)" onclick="deleteDonation(event)">
                                        <i class="gg-delete"></i>
                                    </a>
                                    <label class="selectedDonation-item">{{ $donation['donation-title'] }}</label>
                                    <a class="gg-pen" href="javascript:void(0)" onclick="editDonation(event)"></a>
                                    <input type="hidden" value="{{ json_encode($donation) }}" name="donation-items[]"
                                           id="donitem-{{ $donation['donationID'] }}">
                                </div>
                            @endforeach
                        @endif
                    </label>
                    <i class="gg-arrow-right" id="select-donation" onclick="selectMenu('select-donation')"></i>
                </div>
                @error('donation-items.*')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <div class="btn-container">
                        <button class="delete-btn" onclick="location.href='{{ route('cms-schedule-home') }}'">
                            Verwijderen
                        </button>
                        <button class="regular-btn" type="submit">Opslaan</button>
                    </div>
                </div>
            </div>
            <div class="form-container-right">
                @include('/cms/schedule/create-tables/repeat-form')
                @include('/cms/schedule/create-tables/activity-form')
                @include('/cms/schedule/create-tables/initiative-table')
                @include('/cms/schedule/create-tables/campingbazen-table')
                @include('/cms/schedule/create-tables/vacancy-table')
                @include('/cms/schedule/create-tables/donation-form')
            </div>
        </form>
    </div>
    <script src="{{ asset('/js/cms/schedule-menu.js') }}" defer></script>
    <script src="{{ asset('/js/cms/display-image.js') }}" defer></script>
@endsection
