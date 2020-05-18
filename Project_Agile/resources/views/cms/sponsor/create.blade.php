@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Activities.css') }}" rel="stylesheet">
@endsection

@section('page-title')
Sponsors & partners - Nieuwe aanmaken
@endsection

@section('content')
<form method="POST" id="initiativeSave" action="{{ route('cms-sponsor.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <p class="input-header">Naam:</p>
        <input class="input @error('name') invalid-border @enderror" type="text" placeholder="Voeg naam toe" name="name"
            value="{{ old('name')}}" required/>
        @error('name')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <br><br>

        <p class="input-header">Link:</p>
        <input class="input @error('link') invalid-border @enderror" type="text" placeholder="https://www.weeshuisjes.nl" name="link"
               value="{{ old('link')}}" required/>
        @error('link')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <br><br>

        <p class="input-header">Selecteer een foto:</p>
        <input type="file" name="logo" accept="image/*" required/>
        @error('logo')
        <br>
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror
        <br><br>

        <p class="input-header">Beschrijving:</p>
        <textarea name="description" class="textarea @error('description') invalid-border @enderror"
            placeholder="Typ hier de beschrijving..." required>{{ old('description')}}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        <br>
        @enderror
    </div>
    <div class="btn-container">
        <button class="regular-btn btn-extension">Opslaan</button>
    </div>

</form>

@endsection
