@extends('layouts.cms')

@section('css')
<link href="{{ asset('css/CMS/content.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
<script src="{{ asset('/js/cms/frontend-validation-scroll.js') }}" defer></script>
@endsection

@section('page-title')
Content - Contact opnemen
@endsection

@section('content')
<a href="{{url('contact')}}" target="_blank" class="link">
    <p>Contact opnemen</p><br>
</a>
<form method="POST" action="{{ route('cms-content-contact.update')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="input-container">
    <p class="input-header">Beschrijving:</p>
    <textarea name="contactpage_text" class="textarea @error('contactpage_text') invalid-border @enderror"
        placeholder="Typ hier de inleidende tekst..." required>{{ $singularItems->contactpage_text}}</textarea>
    @error('contactpage_text')
    <span class="invalid-feedback" role="alert">{{ $message }}</span>
    <br>
    @enderror
    </div>
    <br>
    <button class="regular-btn btn-extension">Opslaan</button>
</form>
@endsection