@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Activities.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="{{ asset('/js/cms/TableClickable.js') }}" defer></script>
@endsection

@section('page-title')
    Initiatieven
@endsection

@section('content')

    <table class="table">
        <tr>
            <th>Nummer</th>
            <th>Naam</th>
            <th>Laatste keer gehouden</th>
            <th></th>
        </tr>
        @foreach ($activities as $activity)
            <tr>
                <td>
                    <a href="{{ route('activities.edit',$activity->id)}}">
                        {{$activity->id}}
                    </a>
                </td>
                <td>{{$activity->name}}</td>
                <td>
                    @if ($activity->lastPlanned)
                        {{$activity->lastPlanned}}
                    @else
                        <b>Nog niet</b>
                    @endif
                </td>
                <td class="no-link">
                    @if ($activity->id != 1)
                        <form action="{{ route('activities.destroy', $activity->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="delete-btn" type="submit"
                                    onclick="return confirm('Weet je zeker dat je dit initiatief wilt verwijderen?')">
                                Verwijder
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach

    </table>
    <div class="pagination">
        {{$activities->appends(request()->input())->links()}}
    </div>
    <br>
    <div class="button-container">
        <form action="{{ route('activities.create') }}">
            <button class="regular-btn">Voeg een nieuw initiatief toe!</button>
        </form>
        <form action="{{ route('send_initiative.index') }}">
            <button class="initiative-button regular-btn">Voorgestelde initiatieven</button>
        </form>
    </div>
@endsection
