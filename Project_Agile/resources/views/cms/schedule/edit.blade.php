@extends('layouts.cms')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/schedule-crud.css') }}">
@endsection

@section('page-title')
    Rooster - Ingeplande initiatief bijwerken
@endsection

@section('content')
    <div class="schedule-create-container">
        <form method="POST" action="{{ route('schedule-update', $activityplanned->id) }}" enctype="multipart/form-data">
            <div class="form-container-left">
                @csrf
                @method('PUT')

                <div class="row">
                    <label class="form-label" for="date">Datum:</label>
                    <input class="input-round-border" type="date" name="date"
                           value="{{ \Carbon\Carbon::parse($activityplanned->start_datetime)->format('Y-m-d') }}"
                           required>
                </div>
                @error('date')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="time">Starttijd:</label>
                    <input class="input-round-border" type="time" name="starttime"
                           value="{{ \Carbon\Carbon::parse($activityplanned->start_datetime)->format('H:i') }}"
                           required>
                </div>
                @error('starttime')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="time">Eindtijd:</label>
                    <input class="input-round-border" type="time" name="endtime"
                           value="{{ $activityplanned->end_datetime != null ? \Carbon\Carbon::parse($activityplanned->end_datetime)->format('H:i') : null}}">
                </div>
                @error('endtime')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row">
                    <label class="form-label" for="initiatief">Initiatief:</label>
                    <label class="label-text" id="selectedInitiative">
                        {{ $activityplanned->activity->name }}
                        @if ($activityplanned->existing_activity_id != 1)
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
                        @forelse($activityplanned->campingbazen as $camp)
                            <div class="baas" id="{{ 'camp-' . $camp->id }}">
                                <a href="javascript:void(0)" onclick="deleteFunction(this)">
                                    <i class="gg-delete" id="{{ $camp->firstname }}"></i>
                                </a>
                                <label class="selectedCampingbazen-item">
                                    {{
                                        $camp->firstname
                                        . ' '
                                        . $camp->middlename
                                        . ' '
                                        . $camp->lastname
                                    }}
                                </label>
                            </div>
                        @empty
                            <label class="null-selected label-text">Voeg een campingbaas toe</label>
                        @endforelse
                    </div>
                    <i class="gg-arrow-right" id="select-campingbazen" onclick="selectMenu('select-campingbazen')"></i>
                </div>
                @error('selectedCampingbaasAnswer')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                <div class="row selectedVacancy">
                    <label class="form-label" for="vacancies">Vacatures:</label>
                    @if( $vacancy != null)
                        <div class="label-text label-text-vacancy">
                            <label class="vacancy-header" id="vacancy-name">{{ $vacancy->title }}</label>
                            <label class="vacancy-response">Reacties: {{ $vacancy->openApplicationAmount() }}</label>
                        </div>
                    @else
                        <label class="null-selected label-text" id="vacancy-name">Voeg een vacature toe</label>
                    @endif
                    <div class="vacancy-select-btn-container">
                        <i class="gg-arrow-right" id="select-vacancy" onclick="selectMenu('select-vacancy')"></i>
                        @if( $vacancy != null)
                            <i class="gg-arrow-right" id="select-application"
                               onclick="selectMenu('select-application')"></i>
                        @endif
                    </div>
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
                    <label class="label-text @if(!$donations && !old('donation-items')) null-selected @endif"
                           id="selectedDonation">
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
                        @elseif($donations)
                            @foreach($donations as $don)
                                <div class="don">
                                    <a href="javascript:void(0)" onclick="deleteDonation(event)">
                                        <i class="gg-delete"></i>
                                    </a>
                                    <label class="selectedDonation-item">{{ $don['donation-title'] }}</label>
                                    <a class="gg-pen" href="javascript:void(0)" onclick="editDonation(event)"></a>
                                    <input type="hidden" value="{{ json_encode($don) }}" name="donation-items[]"
                                           id="donitem-{{ $don['donationID'] }}">
                                </div>
                            @endforeach
                        @endif
                    </label>
                    <i class="gg-arrow-right" id="select-donation"
                       onclick="selectMenu('select-donation')"></i>
                </div>
                @error('donation-items.*')
                <div class="error-row">
                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                </div>
                @enderror

                @if (\Carbon\Carbon::today() > $activityplanned->start_datetime)
                    <div class="row">
                        <label class="form-label" for="activity-fotos">Foto's:</label>
                        @if(count($activityplanned->activityPictures) > 0)
                            <label class="label-text">
                                Aantal toegevoegd: {{ count($activityplanned->activityPictures) }}
                            </label>
                        @else
                            <label class="null-selected label-text">Voeg foto's toe</label>
                        @endif
                        <i class="gg-arrow-right" id="select-fotos" onclick="selectMenu('select-fotos')"></i>
                    </div>
                    @error('pictures.*')
                    <div class="error-row">
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    </div>
                    @enderror
                @endif

                <div class="row">
                    <div class="btn-container">
                        <button type="button" class="delete-btn"
                                onclick="if(confirm('Weet u zeker dat u deze ingeplande initiatief wilt verwijderen?')) { location.href='{{ route('schedule-destroy', $activityplanned->id) }}'}">
                            Verwijderen
                        </button>
                        <button class="regular-btn" type="submit">Opslaan</button>
                    </div>
                </div>
            </div>
            <div class="form-container-right">
                @include('/cms/schedule/update-tables/activity-form')
                @include('/cms/schedule/update-tables/initiative-table')
                @include('/cms/schedule/update-tables/campingbazen-table')
                @include('/cms/schedule/update-tables/vacancy-table')
                @include('/cms/schedule/update-tables/donation-form')
                @if ($vacancy != null)
                    @include('/cms/schedule/update-tables/application-table')
                @endif
                @include('/cms/schedule/update-tables/fotos')
            </div>
        </form>
    </div>
    <script src="{{ asset('/js/cms/schedule-menu.js') }}" defer></script>
    <script src="{{ asset('/js/cms/image-uploader.js') }}" defer></script>
    <script src="{{ asset('/js/cms/display-image.js') }}" defer></script>
@endsection
