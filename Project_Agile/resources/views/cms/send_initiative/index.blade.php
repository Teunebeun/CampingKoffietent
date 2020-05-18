@extends('layouts.cms')

@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/CMS/SendInitiative.css') }}">
@endsection

@section('page-title')
    Ingezonden initiatieven
@endsection

@section('content')
    @if(count($initiatives))
        <table class="inbox table">
            <tr>
                <th colspan="2">Ontvangen<a href="{{request()->fullUrlWithQuery(['sortByDate' => $sortByDate])}}"><i
                            class="fa fa-sort"></i></a></th>
                <th>Titel</th>
                <th>Naam</th>
                <th></th>
            </tr>

            @foreach($initiatives as $initiative)
                <tr class="clickable-tr {{(!$initiative->seen) ? "seen" : ""}}">
                    <td>
                        <a href="{{ route('send_initiative.show', $initiative->id) }}">
                            {{\Carbon\Carbon::createFromTimestamp(strtotime($initiative->datetime))->timezone('Europe/Amsterdam')->format('d-m-Y')}}
                        </a>
                    </td>
                    <td>{{\Carbon\Carbon::createFromTimestamp(strtotime($initiative->datetime))->timezone('Europe/Amsterdam')->format('G:i')}}</td>
                    <td>{{$initiative->title}}</td>
                    <td>{{$initiative->initiator->name . ' '. $initiative->initiator->middlename . ' '. $initiative->initiator->lastname}}</td>
                    <td class="no-link">
                        <form action="{{route('send_initiative.destroy', $initiative->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn"
                                    onclick="return confirm('Weet je zeker dat je dit ingezonden initiatief wilt verwijderen?')">
                                Verwijder
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Er zijn geen ingezonden initiatieven!</p>
    @endif
@endsection
