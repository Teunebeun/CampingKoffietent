@extends ('layouts.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('/css/Sponsor.css') }}">
@endsection

@section ('content')
    <h1 class="header"> Sponsoren en partners </h1>

    <div class="sponsor-container">
        <br>
        @foreach($sponsors as $sponsor)
            <div class="sponsor-item">

                <a href="{{ $sponsor->link }}">
                    <img src="{{ asset($sponsor->logo) }}" alt="{{ $sponsor->name }}" title="{{ $sponsor->name }}">
                </a>
                <div class="sponsor-item-textbox">
                    {{ $sponsor->description }}
                </div>

            </div>

            @if(!$loop->last)
                <hr>
            @endif
        @endforeach
    </div>
@endsection

