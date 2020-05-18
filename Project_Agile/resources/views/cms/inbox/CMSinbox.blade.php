@extends('layouts.cms')

@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/Dashboard.css') }}">--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/CMS/Inbox.css') }}">
@endsection

@section('page-title')
    Inbox
@endsection

@section('content')
    @if(count($messages))

    <p class="info">Sorteer op 'Ongelezen'<a class="toggle" href="{{ request()->fullUrlWithQuery(['sortByRead' => $sortByRead]) }}"><i class="gg-toggle-{{($sortByRead === false) ? 'on' : 'off'}} icon"></i></a></p>

    <table class="inbox table">
        <tr>
            <th colspan="2">Ontvangen<a href="{{request()->fullUrlWithQuery(['sortByDate' => $sortByDate])}}"><i class="fa fa-sort"></i></a></th>
            <th>Naam</th>
            <th>Email</th>
            <th>Bericht</th>
            <th></th>
        </tr>

        @foreach($messages as $message)
            <tr class="clickable-tr {{($message->unread) ? "unread" : ""}}">
{{--                {{\Carbon\Carbon::setLocale('app.locale')}}--}}
                <td>
                    <a href="{{ route('inbox.show', $message->id) }}">
                        {{\Carbon\Carbon::createFromTimestamp(strtotime($message->created_at))->timezone('Europe/Amsterdam')->format('d-m-Y')}}
                    </a>
                </td>
                <td>{{\Carbon\Carbon::createFromTimestamp(strtotime($message->created_at))->timezone('Europe/Amsterdam')->format('G:i')}}</td>
                <td>{{$message->name}}</td>
                <td>{{$message->email}}</td>
                <td class="truncated">
                    {{$message->message}}
                </td>
                <td class="no-link">
                    <form action="{{route('inbox.destroy', $message->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">Verwijder</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    @else
        <p>De inbox is helemaal bijgewerkt!</p>
    @endif
@endsection
