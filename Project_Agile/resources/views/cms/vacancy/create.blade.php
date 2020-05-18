@extends('layouts.cms')

@section('css')
<link href="{{ asset('css/CMS/Vacancy.css') }}" rel="stylesheet">
@endsection

@section('page-title')
Vacatures - zonder initiatief
@endsection

@section('content')

<form method="POST" action="{{ route('cms-vacancy.create') }}" enctype="multipart/form-data">
    @csrf
    <div class="container-container">
        <div class="container">
            <p class="input-header">Titel:</p>
            <input class="input @error('title') invalid-border @enderror" type="text" placeholder="Voeg naam toe"
                name="title" value="{{ old('title')}}" required />
            @error('title')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="picture" accept="image/*" />
            @error('picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Startdatum:</p>
            <input class="input @error('startDate') invalid-border @enderror" type="date" name="startDate"
                value="{{ old('startDate')}}">
            @error('startDate')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Starttijd:</p>
            <input class="input @error('startTime') invalid-border @enderror" type="time" name="startTime"
                value="{{ old('startTime')}}">
            @error('startTime')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Eindtijd:</p>
            <input class="input @error('endTime') invalid-border @enderror" type="time" name="endTime"
                   value="{{ old('endTime')}}">
            @error('endTime')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Aantal mensen nodig:</p>
            <input class="input @error('people_amount_required') invalid-border @enderror" type="number" required max="10"
                min="1" name="people_amount_required" placeholder="Aantal mensen" value="{{ old('people_amount_required')}}">
            @error('people_amount_required')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

        </div>
        <div class="container">
            <p class="input-header ">Beschrijving:</p>
            <textarea class="@error('description') invalid-border @enderror" name="description"
                placeholder="Vul hier een beschrijving in." required>{{ old('description')}}</textarea>
            @error('description')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="btn-container">
        <button class="regular-btn btn-extension">Opslaan</button>
    </div>

</form>

@endsection
