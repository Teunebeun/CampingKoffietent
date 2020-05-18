@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/UsersManager.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset('js/editAdmin.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/imageUpload.js') }}" defer></script>
@endsection

@section('page-title')
    Account beheer
@endsection

@section('content')
    <form enctype="multipart/form-data" class="form-container" method="post"
          action="{{ route('users.update', $account->id) }}">
        @method('PATCH')
        @csrf
        <div id="profile-container-border" class="profile-container-border">
            <div id="profile-picture-container" class="profile-picture-container">
                <label class="profile-picture-label" for="image_upload">
                    @if ($account->profile_picture == null)
                        <img name="profile_picture" id="profile_picture" class="profile-picture"
                             src="{{ URL::asset('img/profile_picture_placeholder.svg') }}">
                    @else
                        <img name="profile_picture" id="profile_picture" class="profile-picture"
                             src="{{ URL::asset($account->profile_picture) }}">
                    @endif
                    <input type="hidden" id="imageValue" name="imageValue"/>
                </label>
                <input type="file" name="profile_picture" id="image_upload" accept="image/*"
                       class="form-control upload-image">
            </div>
            <div class="input-rows">
                <div class="profile-row row">
                    <div class="input-label-container">
                        <label for="name"
                               class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Voornaam') }}</label>
                    </div>
                    <div class="col-md-6 label_edit">
                        <input placeholder="Vul voornaam in"  readonly="readonly" id="name" type="text"
                               class="input form-control crud-form  @error('name') is-invalid @enderror"
                               name="name" value="{{ $account->name }}" required>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <a href="#"><img class="edit" src="{{ URL::asset('img/edit-pen.svg') }}"></a>
                    </div>
                </div>

                <div class="profile-row row">
                    <div class="input-label-container">
                        <label for="middlename"
                               class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Tussenvoegsel') }}</label>
                    </div>
                    <div class="col-md-6 label_edit">
                        <input placeholder="Vul tussenvoegsel in"  readonly="readonly" id="middlename" type="text"
                               class="input form-control crud-form @error('middlename') is-invalid @enderror"
                               name="middlename"
                               value="{{ $account->middlename }}">

                        @error('middlename')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <a href="#"><img class="edit" src="{{ URL::asset('img/edit-pen.svg') }}"></a>
                    </div>
                </div>

                <div class="profile-row row">
                    <div class="input-label-container">
                        <label for="lastname"
                               class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Achternaam') }}</label>
                    </div>
                    <div class="col-md-6 label_edit">
                        <input placeholder="Vul achternaam in"  readonly="readonly" id="lastname" type="text"
                               class="input form-control crud-form @error('lastname') is-invalid @enderror"
                               name="lastname" value="{{ $account->lastname }}" required>

                        @error('lastname')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <a href="#"><img class="edit" src="{{ URL::asset('img/edit-pen.svg') }}"></a>
                    </div>
                </div>
                <div class="profile-row row">
                    <div class="input-label-container">
                        <label for="phonenumber"
                               class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Telefoon nummer') }}</label>
                    </div>
                    <div class="col-md-6 label_edit">
                        <input placeholder="Vul telefoonnummer in"  readonly="readonly" id="phonenumber" type="tel"
                               class="input form-control crud-form @error('phonenumber') is-invalid @enderror"
                               name="phonenumber" value="{{ $account->phonenumber }}">

                        @error('phonenumber')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <a href="#"><img class="edit" src="{{ URL::asset('img/edit-pen.svg') }}"></a>
                    </div>
                </div>
                <div class="profile-row row">
                    <div class="input-label-container">
                        <label for="email"
                               class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>
                    </div>
                    <div class="col-md-6 label_edit">
                        <input placeholder="Vul E-mail in"  readonly="readonly" id="email" type="email"
                               class="input form-control crud-form @error('email') is-invalid @enderror"
                               name="email" value="{{ $account->email }}" required>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                        <a href="#"><img class="edit" src="{{ URL::asset('img/edit-pen.svg') }}"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="small recommended-size">
            <p>
                *Het aanbevolen foto formaat is 256x256 pixels.
            </p>
        </div>
        <button type="button" id="clear-profile-picture" class="delete-btn">Verwijder profielfoto</button>
        <button type="submit" class="regular-btn">Opslaan</button>
        @if (Route::has('password.request'))
            <button type="button" class="regular-btn" onclick="location.href='{{ route('password.request') }}'">
                Wachtwoord veranderen
            </button>
        @endif
    </form>
@endsection
