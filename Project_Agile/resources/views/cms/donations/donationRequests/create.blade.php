@extends('layouts.cms')

@section('css')
    <link href="{{asset('css/cms/donations.css')}}" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection

@section('page-title')
    Donaties
@endsection

@section('content')
    <div class="container">
        <div class="column1">
            <div class="header-wrapper">
                <h1>Donatie Aanvragen</h1>
                <h3>Zonder initiatief</h3>
            </div>

            <form class="request" action="{{ route('donationRequest.store') }}" method="POST">
                @csrf
                @method('POST')

                <label for="title">Titel:</label>
                <input type="text" name="title" placeholder="Titel" value="{{old('title')}}" required/>
                @error('title')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <label for="donation_item">Voorwerp:</label>
                <input type="voorwerp" name="donation_item" placeholder="Welk voorwerp wil je aanvragen?" value="{{old('donation_item')}}" required/>
                @error('donation_item')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <label for="donation_needed">Aantal:</label>
                <input type="number" name="donation_needed" value="{{old('donation_needed')}}" placeholder="Aantal" min="0" max="99999999.99" step="0.01" required/>
                @error('donation_needed')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <label for="description">Beschrijving:</label>
                <textarea name="description" placeholder="Vul hier een beschrijving in..." required>{{old('description')}}</textarea>
                @error('description')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <div class="button-wrapper">
                    <a href="{{ route('donations.index') }}">
                        <button type="button" class="delete-btn">Annuleren</button>
                    </a>
                    <button type="submit" class="regular-btn">Opslaan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
