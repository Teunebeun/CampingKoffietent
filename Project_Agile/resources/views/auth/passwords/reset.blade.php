<head>
    <link href="{{ asset('/css/CMS/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div class="content">
    <img src="{{ asset("/img/CampingKoffietentImage.png") }}" class="logo" />
    <h1>Beheersysteem</h1>
    <h4>Wachtwoord Herstel</h4>

    <a href="{{ route('login') }}" id="return"><i class="fas fa-arrow-left"></i></a>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        @error('password')
        <div class="error">
            <strong>{{ $message }}</strong>
        </div>
        @enderror

        <div class="field">
            <input id="email" type="email" class="@error('email') error @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="E-mail Adres...">

            @error('email')
            <span class="error">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="field">
            <input id="password" type="password" class="@error('password') error @enderror" name="password" placeholder="Wachtwoord...">
        </div>

        <div class="field">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Bevestig wachtwoord...">
        </div>

        <div class="field">
            <input type="submit" value="Bevestig wijziging">
        </div>
    </form>
</div>
