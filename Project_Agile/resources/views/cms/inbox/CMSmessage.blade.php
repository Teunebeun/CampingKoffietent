@extends('layouts.cms')

@section('css')
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/Inbox.css') }}">
@endsection

@section('page-title')
    Inbox
@endsection

@section('content')
    <div class="field">
        <span>Van:</span>
        <span>{{$message->email}}</span>
    </div>
    <div class="field">
        <span>Datum:</span>
        <span>{{\Carbon\Carbon::parse($message->created_at)->format('d-m-Y')}}</span>
    </div>
    <div class="field">
        <span>Tijdstip:</span>
        <span>{{\Carbon\Carbon::parse($message->created_at)->format('G:i')}}</span>
    </div>
    <div class="message">
        {{$message->message}}
    </div>
    <form action="{{route('inbox.destroy', $message->id)}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-btn">Verwijder</button>
    </form>
    <form action="{{route('inbox.update', $message->id)}}" method="POST">
        @csrf
        @method('PUT')
        <button type="submit" class="regular-btn">Markeer als Ongelezen</button>
    </form>
@endsection
