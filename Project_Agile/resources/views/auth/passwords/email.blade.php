<head>
    <link href="{{ asset('/css/CMS/login.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<div class="content">
    <img src="{{ asset("/img/CampingKoffietentImage.png") }}" class="logo" />
    <h1>Beheersysteem</h1>
    <h4>Wachtwoord Herstel</h4>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="field">
                <input id="email" type="email" class="@error('email') error @enderror" name="email" placeholder="E-mail Adres..." value="{{ old('email') }}" required autofocus>

                @error('email')
                <span class="error" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="field">
                <input type="submit" value="Verstuur"/>
            </div>
        </form>

    <a href="{{ route('login') }}" id="return"><i class="fas fa-arrow-left"></i></a>
</div>
