@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Activities.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    Sponsors & partners - Wijzigen
@endsection

@section('content')
    <form method="POST" id="initiativeSave" action="{{ route('cms-sponsor.update', $sponsor->id)}}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">
            <p class="input-header">Naam:</p>
            <input class="input @error('name') invalid-border @enderror" type="text" placeholder="Voeg naam toe"
                   name="name"
                   value="{{ $sponsor->name}}" required/>
            @error('name')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Link:</p>
            <input class="input @error('link') invalid-border @enderror" placeholder="https://www.weeshuisjes.nl"
                   name="link" value="{{ $sponsor->link}}" required/>
            @error('link')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="logo" accept="image/*"/>
            <br><br>
            @if ($sponsor->logo)
                <td><img src="{{ URL::asset($sponsor->logo) }}" height="150px"></td>
            @else
                <td>Geen afbeelding</td>
            @endif
            @error('logo')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror

            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea name="description" class="textarea @error('description') invalid-border @enderror"
                      placeholder="Typ hier de beschrijving..." required>{{ $sponsor->description}}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror
        </div>
    </form>
    <div class="btn-container">
        <form action="{{ route('cms-sponsor.destroy', $sponsor->id)}}" method="post" style="width: 48%">
            @csrf
            @method('DELETE')
            <button class="delete-btn btn-extension" type="submit" style="width: 100%"
                    onclick="return confirm('Weet je zeker dat je deze sponsor/partner wilt verwijderen?')">
                Verwijder
            </button>
        </form>

        <button class="regular-btn btn-extension" form="initiativeSave">Opslaan</button>
    </div>



@endsection
