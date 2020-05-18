@extends('layouts.cms')

@section('css')
<link href="{{ asset('css/CMS/content.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
<script src="{{ asset('/js/cms/frontend-validation-scroll.js') }}" defer></script>
@endsection

@section('page-title')
Content - Hoofdpagina
@endsection

@section('content')
<div class="flex-container">
    <a href="{{ route('cms-content-homepage.edit') }}" class="content-link">
        <p>Inleiding</p><br>
    </a>
    <p class="content-new-link">-</p>
    <a href="{{ route('cms-content-homepage.edit') }}#doe-mee" class="content-link">
        <p>Doe mee</p><br>
    </a>
</div>
<br>
<a href="{{ route('home') }}" target="_blank" class="link">
    <p>Inleiding</p><br>
</a>
<form method="POST" action="{{ route('cms-content-homepage.update')}}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="flex-container">
        <div class="input-container">
            <p class="input-header">Titel inleidende tekst:</p>
            <input class="input @error('homepage_title') invalid-border @enderror" type="text"
                placeholder="Voeg titel inleidende tekst toe" name="homepage_title"
                value="{{ $singularItems->homepage_title}}" required/>
            @error('homepage_title')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="homepage_picture" accept="image/*" />
            @error('homepage_picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>

        <div class="input-container">
            <p class="input-header">Inleidende tekst:</p>
            <textarea name="homepage_text"
                class="textarea @error('homepage_text') invalid-border @enderror width-extension"
                placeholder="Typ hier de inleidende tekst..." required>{{ $singularItems->homepage_text}}</textarea>
            @error('homepage_text')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror
        </div>
    </div>
    <br><br>
    <a href="{{ route('home') }}#doe-mee" target="_blank" class="link" id="doe-mee">
        <p>Doe mee</p><br>
    </a>

    <div class="flex-container">
        <div class="input-container input-container-background">
            <p class="sub-title">Koffie</p>
            <p class="input-header">Titel:</p>
            <input class="input @error('coffee_title') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="coffee_title" value="{{ $singularItems->coffee_title}}" required/>
            @error('coffee_title')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="coffee_picture" accept="image/*" />
            @error('coffee_picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea name="coffee_text"
                class="textarea @error('coffee_text') invalid-border @enderror textarea-width-extension"
                placeholder="Typ hier de beschrijving..." required>{{ $singularItems->coffee_text}}</textarea>
            @error('coffee_text')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror

            <p class="input-header">Knop tekst:</p>
            <input class="input @error('coffee_button') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="coffee_button" value="{{ $singularItems->coffee_button}}" required/>
            @error('coffee_button')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
        <div class="input-container input-container-background">
            <p class="sub-title">Initiatief organiseren</p>
            <p class="input-header">Titel:</p>
            <input class="input @error('activity_title') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="activity_title" value="{{ $singularItems->activity_title}}" required/>
            @error('activity_title')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="activity_picture" accept="image/*" />
            @error('activity_picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea name="activity_text"
                class="textarea @error('activity_text') invalid-border @enderror textarea-width-extension"
                placeholder="Typ hier de beschrijving..." required>{{ $singularItems->activity_text}}</textarea>
            @error('activity_text')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror

            <p class="input-header">Knop tekst:</p>
            <input class="input @error('activity_button') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="activity_button" value="{{ $singularItems->activity_button}}" required/>
            @error('activity_button')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
    </div>

    <div class="flex-container">
        <div class="input-container input-container-background">
            <p class="sub-title">Helpen met een initiatief</p>
            <p class="input-header">Titel:</p>
            <input class="input @error('help_title') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="help_title" value="{{ $singularItems->help_title}}" required/>
            @error('help_title')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="help_picture" accept="image/*" />
            @error('help_picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea name="help_text"
                class="textarea @error('help_text') invalid-border @enderror textarea-width-extension"
                placeholder="Typ hier de beschrijving..." required>{{ $singularItems->help_text}}</textarea>
            @error('help_text')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror

            <p class="input-header">Knop tekst:</p>
            <input class="input @error('help_button') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="help_button" value="{{ $singularItems->help_button}}" required/>
            @error('help_button')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
        <div class="input-container input-container-background">
            <p class="sub-title">Doneren</p>
            <p class="input-header">Titel:</p>
            <input class="input @error('donate_title') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="donate_title" value="{{ $singularItems->donate_title}}" required/>
            @error('donate_title')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="donate_picture" accept="image/*" />
            @error('donate_picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea name="donate_text"
                class="textarea @error('donate_text') invalid-border @enderror textarea-width-extension"
                placeholder="Typ hier de beschrijving..." required>{{ $singularItems->donate_text}}</textarea>
            @error('donate_text')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror

            <p class="input-header">Knop tekst:</p>
            <input class="input @error('donate_button') invalid-border @enderror width-extension" type="text"
                placeholder="Voeg titel toe" name="donate_button" value="{{ $singularItems->donate_button}}" required/>
            @error('donate_button')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
    </div>
    <br>
    <button class="regular-btn btn-extension">Opslaan</button>
</form>


@endsection