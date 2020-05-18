@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/UsersManager.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset('js/imageUpload.js') }}" defer></script>
@endsection

@section('page-title')
    Account beheer
@endsection

@section('content')
    <form enctype="multipart/form-data" method="post" class="form-container-create"
          action="{{ route('users.store') }}">
        @csrf
        <div id="profile-container-border" class="profile-container-border-create">
            <div id="profile-picture-container" class="profile-picture-container-create">
                <label class="profile-picture-label-create" for="image_upload">
                    <img name="profile_picture" id="profile_picture" class="profile-picture-create"
                         src="{{ URL::asset('img/profile_picture_placeholder.svg') }}">
                    <input type="hidden" id="imageValue" name="imageValue"/>
                </label>
                <input type="file" name="profile_picture" id="image_upload" accept="image/*"
                       class="form-control upload-image">
            </div>

            <div class="small recommended-size-create">
                <p>
                    *Het aanbevolen foto formaat is 256x256 pixels.
                </p>
            </div>
            <div class="input-colum">
                <div class="input-rows-create">
                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="name"
                                   class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Voornaam') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul voornaam in" id="name" type="text"
                                   class="input form-control crud-form  @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" autocomplete="name" autofocus required>

                            @error('name')
                            <span class="invalid-feedback invalid-feedback-create" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="middlename"
                                   class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Tussenvoegsel') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul tussenvoegsel in" id="middlename" type="text"
                                   class="input form-control crud-form  @error('middlename') is-invalid @enderror"
                                   name="middlename"
                                   value="{{ old('middlename') }}" autocomplete="middlename" autofocus>

                            @error('middlename')
                            <span class="invalid-feedback invalid-feedback-create" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="lastname"
                                   class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Achternaam') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul achternaam in" id="lastname" type="text"
                                   class="input form-control crud-form  @error('lastname') is-invalid @enderror"
                                   name="lastname"
                                   value="{{ old('lastname') }}" autocomplete="lastname" autofocus required>

                            @error('lastname')
                            <span class="invalid-feedback invalid-feedback-create" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="phonenumber"
                                   class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Telefoonnummer') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul telefoonnummer in" id="phonenumber" type="text"
                                   class="input form-control crud-form  @error('phonenumber') is-invalid @enderror"
                                   name="phonenumber" value="{{ old('phonenumber') }}"
                                   autocomplete="phonenumber"
                                   autofocus>

                            @error('phonenumber')
                            <span class="invalid-feedback invalid-feedback-create" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="input-rows-create">
                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="email"
                                   class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('E-mailadres') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul E-mail in" id="email" type="email"
                                   class="input form-control crud-form  @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" autocomplete="email" required>

                            @error('email')
                            <span class="invalid-feedback invalid-feedback-create" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="password"
                                   class="font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Wachtwoord') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul wachtwoord in" id="password" type="password"
                                   class="input form-control crud-form  @error('password') is-invalid @enderror"
                                   name="password"
                                   autocomplete="new-password" required>

                            @error('password')
                            <span class="invalid-feedback invalid-feedback-create" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="profile-row-create form-group row">
                        <div class="input-label-container">
                            <label for="password-confirm"
                                   class="password-confirm font-weight-bold col-md-4 col-form-label text-md-left">{{ __('Wachtwoord herhalen') }}</label>
                        </div>
                        <div class="col-md-6 label_edit">
                            <input placeholder="Vul bevestiging in" id="password-confirm" type="password"
                                   class="input form-control crud-form "
                                   name="password_confirmation" autocomplete="new-password" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-button">
            <button id="clear-profile-picture" class="delete-btn">Verwijder profielfoto</button>
            <button type="submit" class="regular-btn">Creëer account</button>
        </div>
    </form>
@endsection
