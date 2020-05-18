@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/contact.css') }}">
@endsection

@section('content')
    <div class="wrapper">
        <div class="content clearfix">

            <h1>Contact</h1>

            <hr/>

            <p>
                {{ $text }}
            </p>

            <form method="POST" action="{{url()->current()}}" id="form-contact">
                @csrf

                <div class="field-grid">
                    <label for="name">Naam: </label>
                    <input type="text" value="{{ request()->old('name') }}" placeholder="Hoe heet je?" name="name" autocomplete="off" required/>

                    @error('name')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror

                    <label for="email">E-mail: </label>
                    <input type="email" value="{{ request()->old('email') }}" placeholder="Hoe kunnen we je bereiken?" name="email" autocomplete="off" required/>

                    @error('email')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror

                    <textarea type="textarea" placeholder="Wat wil je kwijt?" name="message" autocomplete="off" required>{{ request()->old('message') }}</textarea>

                    @error('message')
                    <div class="error">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <input type="submit" value="verstuur!" />
            </form>
        </div>
    </div>
@endsection
