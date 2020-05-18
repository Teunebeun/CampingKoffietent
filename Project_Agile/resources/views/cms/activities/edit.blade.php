@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Activities.css') }}" rel="stylesheet">
@endsection

@section('page-title')
    Initiatieven - Wijzigen
@endsection

@section('content')
    <form method="POST" id="initiativeSave" action="{{ route('activities.update', $activity->id)}}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container">
            <p class="input-header">Naam:</p>
            <input class="input @error('name') invalid-border @enderror" type="text" placeholder="Voeg naam toe"
                   name="name"
                   value="{{ $activity->name}}" required/>
            @error('name')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

        <p class="input-header">Bedenker:</p>
        <select id="creator" class="input @error('creator') invalid-border @enderror extended-length"
                placeholder="Wie heeft dit initiatief bedacht?"
                name="creator"
                value="{{ $activity->creator}}">
            @foreach($employees as $employee)
                <option value="{{$employee->id}}"
                @if($employee->id == $activity->creator)
                    selected
                @endif
                >{{$employee->firstname}}</option>
            @endforeach
        </select>
        <br><br>

        <p class="input-header">Selecteer een foto:</p>
        <input type="file" name="picture" accept="image/*" onchange="readURL(this, 'initiative-image')"/>
        <br><br>
        @if ($activity->picture)
        <td><img id="initiative-image" src="{{ URL::asset($activity->picture) }}" width="150px" height="150px"></td>
        @else
        <td>Geen afbeelding</td>
        @endif
        @error('picture')
        <br>
        <span class="invalid-feedback" role="alert">{{ $message }}</span>
        @enderror

            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea name="description" class="textarea @error('description') invalid-border @enderror"
                      placeholder="Typ hier de beschrijving..." required>{{ $activity->description}}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror
        </div>
    </form>
    <div class="btn-container">
        @if($activity->id != 1)
            <form action="{{ route('activities.destroy', $activity->id)}}" method="post" style="width: 48%">
                @csrf
                @method('DELETE')
                <button class="delete-btn btn-extension" type="submit" style="width: 100%"
                        onclick="return confirm('Weet je zeker dat je deze activiteit wilt verwijderen?')">
                    Verwijder
                </button>
            </form>
        @endif

        <button class="regular-btn btn-extension" form="initiativeSave">Opslaan</button>
    </div>

    <script src="{{ asset('/js/cms/display-image.js') }}" defer></script>

@endsection
