@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Vacancy.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    Vacature
@endsection

@section('content')

    <form method="POST" id="editForm" action="{{ route('cms-vacancy.update', $vacancy) }}"
          enctype="multipart/form-data">
        @csrf
        <div class="container-container">
            <div class="container">
                <p class="input-header">Titel:</p>
                <input class="input @error('title') invalid-border @enderror" type="text" placeholder="Voeg naam toe"
                       name="title" value="{{ $vacancy->title}}" required/>
                @error('title')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Initiatief:
                    <span class="notbold">
                        @if($vacancy->activity)
                            {{ $vacancy->activity->name}}
                        @else
                            -
                        @endif
                    </span></p>
                <br>

                <p class="input-header">Selecteer een foto:</p>
                <input type="file" name="picture" accept="image/*" onchange="readURL(this, 'vacancy-image')"/>
                @error('picture')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror

                @if($vacancy->picture)
                    <br><br>
                    <img src="{{asset($vacancy->picture)}}" id="vacancy-image">
                @endif
                <br><br>

                <p class="input-header">Startdatum: </p>
                <input class="input @error('startDate') invalid-border @enderror" type="date" name="startDate"
                       value="{{ $vacancy->start_datetime ? \Carbon\Carbon::parse($vacancy->start_datetime)->format('Y-m-d') : null }}">
                @error('startDate')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Starttijd:</p>
                <input class="input @error('startTime') invalid-border @enderror" type="time" name="startTime"
                       value="{{ $vacancy->start_datetime ? \Carbon\Carbon::parse($vacancy->start_datetime)->format('H:i') : null }}">
                @error('startTime')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Eindtijd:</p>
                <input class="input @error('endTime') invalid-border @enderror" type="time" name="endTime"
                       value="{{ $vacancy->end_datetime ? \Carbon\Carbon::parse($vacancy->end_datetime)->format('H:i') : null }}">
                @error('endTime')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Aantal mensen nodig:</p>
                <input class="input @error('people_amount_required') invalid-border @enderror" type="number" required max="10"
                       min="1" name="people_amount_required" placeholder="Aantal mensen" value="{{ $vacancy-> people_amount_required }}">
                @error('people_amount_required')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Vacature is zichtbaar voor bezoekers: </p>
                <input class="input @error('is_open') invalid-border @enderror" type="checkbox" name="is_open"
                       @if($vacancy->is_open) checked @endif value="true">
                @error('is_open')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>
            </div>
            <div class="container">
                <p class="input-header ">Beschrijving:</p>
                <textarea class="@error('description') invalid-border @enderror" name="description"
                          placeholder="Vul hier een beschrijving in." required>{{ $vacancy->description}}</textarea>
                @error('description')
                <br>
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </form>

    <div class="btn-container">
        <form method="post" action="{{ route('cms-vacancy.destroy', $vacancy->id) }}">
            @method('Delete')
            @csrf
            <button class="delete-btn btn-extension"
                    onclick="return confirm('Weet je zeker dat je deze vacature wilt verwijderen?')">Verwijderen
            </button>
        </form>

        <button form="editForm" class="regular-btn btn-extension">Opslaan</button>
    </div>
    <script src="{{ asset('/js/cms/display-image.js') }}" defer></script>
@endsection
