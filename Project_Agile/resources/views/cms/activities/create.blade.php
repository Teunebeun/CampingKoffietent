@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Activities.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ URL::asset('js/CMS/autofillActivity.js') }}"
            defer>
    </script>
    <script>
            @isset($initiative)
        let initiative = {!! json_encode($initiative->toArray()) !!};
        @endisset
    </script>
@endsection

@section('page-title')
    Initiatieven - Nieuwe aanmaken
@endsection

@section('content')
    <form method="POST" id="initiativeSave" action="{{ route('activities.store') }}" enctype="multipart/form-data">
        @csrf
        @isset($initiative)
            <input name="initiator_id" type="hidden" value="{{$initiative->initiator->id}}">
            <input id="initiative_id" name="initiative_id" type="hidden" value="{{$initiative->id}}">
        @endisset
        <div class="container">
            <p class="input-header">Naam:</p>
            <input id="name" class="input @error('name') invalid-border @enderror" type="text"
                   placeholder="Voeg naam toe"
                   name="name"
                   value="{{ old('name')}}" required/>
            @error('name')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Bedenker:</p>
            <select id="creator" class="input @error('creator') invalid-border @enderror extended-length"
                   placeholder="Wie heeft dit initiatief bedacht?"
                   name="creator"
                   value="{{ old('creator')}}">
                @foreach($employees as $employee)
                    <option value="{{$employee->id}}"
                    @if($loop->last)
                        @isset($initiative)
                            selected
                        @endisset
                    @endif
                    >{{$employee->firstname}}</option>
                @endforeach

            </select>
            @error('creator')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Selecteer een foto:</p>
            <input type="file" name="picture" accept="image/*" required/>
            @error('picture')
            <br>
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
            <br><br>

            <p class="input-header">Beschrijving:</p>
            <textarea id="description" name="description"
                      class="textarea @error('description') invalid-border @enderror"
                      placeholder="Typ hier de beschrijving..." required>{{ old('description')}}</textarea>
            @error('description')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            <br>
            @enderror
        </div>
        <div class="btn-container">
            <button class="regular-btn btn-extension">Opslaan</button>
        </div>

    </form>

@endsection
