@extends('layouts.cms')

@section('css')
<link href="{{ asset('css/CMS/content.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
<script src="{{ asset('/js/cms/frontend-validation-scroll.js') }}" defer></script>
@endsection

@section('page-title')
Content - Initiatieven
@endsection

@section('content')
<a href="{{ route('initiative') }}" target="_blank" class="link">
    <p>Koffie initiatief</p><br>
</a>
<form method="POST" action="{{ route('cms-content-initiative.update', $activity->id)}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="input-container">
        <p class="input-header">Koffie initiatief naam:</p>
        <input class="input @error('name') invalid-border @enderror" type="text" placeholder="Voeg naam toe" name="name"
            value="{{ $activity->name}}" required />
        @error('name')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <br><br>

        <p class="input-header">Selecteer een foto:</p>
        <input type="file" name="display_picture" accept="image/*" />
        @error('display_picture')
        <br>
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <br><br>

        <p class="input-header">Koffie initiatief beschrijving:</p>
        <textarea name="description" class="textarea @error('description') invalid-border @enderror"
            placeholder="Typ hier de beschrijving..." required>{{ $activity->description}}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        <br>
        @enderror
    </div>
    <br>
    <button class="regular-btn btn-extension">Opslaan</button>
</form>
@endsection