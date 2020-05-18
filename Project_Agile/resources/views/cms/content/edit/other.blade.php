@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/content.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="{{ asset('/js/cms/frontend-validation-scroll.js') }}" defer></script>
    <script src="{{asset('/js/cms/HandleContentOtherSites.js')}}" defer></script>
@endsection

@section('page-title')
    Content - Overig
@endsection

@section('content')
    <form method="POST" action="{{ route('cms-content-other.update')}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <a href="{{ route('home') }}" target="_blank" class="link">
            <p>Menubalk</p><br>
        </a>
        <div class="input-container">
            <p class="input-header">Selecteer een logo:</p>
            <input type="file" name="homepage_logo" accept="image/*"/>
            @error('homepage_logo')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>
        </div>
        <a href="{{ route('home') }}#footer" target="_blank" class="link">
            <p>Footer</p><br>
        </a>
        <div class="flex-container">
            <div class="input-container">

                <br>
                <p class="sub-title">Adres</p>
                <p class="input-header">Straat + huisnummer:</p>
                <input class="input @error('adres_street') invalid-border @enderror" type="text"
                       placeholder="Voeg straat + huisnummer toe" name="adres_street"
                       value="{{ $singularItems->adres_street}}" required/>
                @error('adres_street')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Postcode + stad:</p>
                <input class="input @error('adres_place') invalid-border @enderror" type="text"
                       placeholder="Voeg postcode + stad toe" name="adres_place"
                       value="{{ $singularItems->adres_place}}" required/>
                @error('adres_place')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <br>

                <div class="other-sites-header-container">
                    <p class="sub-title">Linkjes naar websites</p>
                    <button class="regular-btn other-site-button" id="add-other-site-button" type="button"> + </button>
                </div>


                <div class="other-sites-container">
                    @foreach($footerLinks as $footerLink)
                        <div class="other-site">
                            <div class="other-site-name-container">
                                <p class="input-header"> Naam - {{ $footerLink->id }}:</p>
                                <button class="delete-btn other-site-button other-delete" type="button"> x </button>
                            </div>

                            <input class="input @error('otherSitesName.' . $loop->index) invalid-border @enderror"
                                   type="text"
                                   maxlength="60"
                                   placeholder="Voeg naam toe"
                                   name="otherSitesName[]"
                                   value="{{ $footerLink-> name}}"
                                   required
                            />
                            @error('otherSitesName*' . $loop->index)
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                            <br><br>

                            <p class="input-header"> Link - {{$footerLink->id}}:</p>
                            <input class="input @error('otherSitesLink.' . $loop->index) invalid-border @enderror"
                                   type="text"
                                   maxlength="200"
                                   placeholder="Voeg link toe"
                                   name="otherSitesLink[]"
                                   value="{{ $footerLink-> link}}"
                                   required
                            />
                            @error('otherSitesLink*' . $loop->index)
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                            <br><br>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="input-container">
                <br>
                <p class="sub-title">Sociale media</p>
                <p class="input-header">Facebook link:</p>
                <input class="input @error('facebook_link') invalid-border @enderror" type="text"
                       placeholder="Voeg Facebook link toe" name="facebook_link"
                       value="{{ $singularItems->facebook_link}}" required/>
                @error('facebook_link')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Instagram link:</p>
                <input class="input @error('instagram_link') invalid-border @enderror" type="text"
                       placeholder="Voeg Instagram link toe" name="instagram_link"
                       value="{{ $singularItems->instagram_link}}" required/>
                @error('instagram_link')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">Twitter link</p>
                <input class="input @error('twitter_link') invalid-border @enderror" type="text"
                       placeholder="Voeg Twitter link toe" name="twitter_link" value="{{ $singularItems->twitter_link}}"
                       required/>
                @error('twitter_link')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>

                <p class="input-header">E-mailadres:</p>
                <input class="input @error('email_link') invalid-border @enderror" type="text"
                       placeholder="Voeg e-mailadres toe" name="email_link" value="{{ $singularItems->email_link}}"
                       required/>
                @error('email_link')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                <br><br>
            </div>
        </div>
        <button class="regular-btn btn-extension">Opslaan</button>
    </form>
@endsection
