@extends('layouts.cms')

@section('css')
<link href="{{ asset('css/CMS/content.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
<script src="{{ asset('/js/cms/frontend-validation-scroll.js') }}" defer></script>
@endsection

@section('page-title')
Content - Openingstijden
@endsection

@section('content')
<a href="{{ route('openingHours') }}" target="_blank" class="link">
    <p>Openingstijden voor de komende 7 dagen</p><br>
</a>
<p class="help">*Laat veld leeg wanneer gesloten</p>
<p class="help">*De standaard indeling is "12:00-13:00". Om meerdere tijden toe te voegen kan je " & " gebruiken,
    voorbeeld: ''12:00-13:00 & 14:00-16:00''.</p>
<form method="POST" action="{{ route('cms-content-openingHours.update')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="flex-container">
        <div class="input-container">
            <p class="input-header">Maandag openingstijd:</p>
            <input class="input @error('opentime_monday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_monday"
                value="{{ $singularItems->opentime_monday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_monday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Dinsdag openingstijd:</p>
            <input class="input @error('opentime_tuesday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_tuesday"
                value="{{ $singularItems->opentime_tuesday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_tuesday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Woensdag openingstijd:</p>
            <input class="input @error('opentime_wednesday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_wednesday"
                value="{{ $singularItems->opentime_wednesday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_wednesday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Donderdag openingstijd:</p>
            <input class="input @error('opentime_thursday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_thursday"
                value="{{ $singularItems->opentime_thursday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_thursday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>

        <div class="input-container">
            <p class="input-header">Vrijdag openingstijd:</p>
            <input class="input @error('opentime_friday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_friday"
                value="{{ $singularItems->opentime_friday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_friday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Zaterdag openingstijd:</p>
            <input class="input @error('opentime_saturday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_saturday"
                value="{{ $singularItems->opentime_saturday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_saturday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Zondag openingstijd:</p>
            <input class="input @error('opentime_sunday') invalid-border @enderror" type="text"
                placeholder="Laat leeg wanneer gesloten" name="opentime_sunday"
                value="{{ $singularItems->opentime_sunday}}"
                pattern="^[0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}( & [0-9]{2}:[0-9]{2}-[0-9]{2}:[0-9]{2}){0,2}$"
                title="Voorbeeld: 10:00-11:00 & 12:00-13:00 & 14:00-15:00" />
            @error('opentime_sunday')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
    </div>

    <a href="{{ route('openingHours') }}" target="_blank" class="link">
        <p>Locatie</p><br>
    </a>

    <div class="flex-container">
        <div class="input-container">
            <p class="input-header">Locatie link:</p>
            <input class="input @error('location_link') invalid-border @enderror" type="text"
                placeholder="Voeg locatie link toe" name="location_link" value="{{ $singularItems->location_link}}" required/>
            @error('location_link')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
    </div>

    <button class="regular-btn btn-extension">Opslaan</button>
</form>
@endsection
