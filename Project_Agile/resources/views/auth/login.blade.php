<head>
    <link href="{{ asset('/css/CMS/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div class="content">
    <img src="{{ asset("/img/CampingKoffietentImage.png") }}" class="logo" />
    <h1>Beheersysteem</h1>
    <h4>Inloggen</h4>

    <a href="{{ route('home') }}" id="return"><i class="fas fa-arrow-left"></i></a>

    <form method="POST" action="{{route('login')}}">
        @csrf

        @error('credentials')
             <div class="error">
                {{ $message }}
             </div>
        @enderror

        <div class="field">
            <input id="email" type="text" class="@error('credentials') error @enderror" name="email" value="{{ old('email') }}" placeholder="E-mail Adres...">

            @error('email')
            <span class="error">
                {{ $message }}
             </span>
            @enderror
        </div>

        <div class="field">
            <input id="password" type="password" class="@error('credentials') error @enderror" name="password" placeholder="Wachtwoord...">
        </div>

        @if (Route::has('password.request'))
            <p>
                <a class="" href="{{ route('password.request') }}">
                    {{ __('Wachtwoord vergeten?') }}
                </a>
            </p>
        @endif

        <div class="field">
            <input type="submit" value="Inloggen">
        </div>
    </form>
</div>
