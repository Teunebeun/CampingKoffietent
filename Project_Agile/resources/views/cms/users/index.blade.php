@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/UsersManager.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="{{ asset('/js/cms/TableClickable.js') }}" defer></script>
@endsection

@section('page-title')
    Account beheer
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <table class="table">
        <tr>
            <th>Voornaam</th>
            <th>Tussenvoegsel</th>
            <th>Achternaam</th>
            <th>Telefoonnummer</th>
            <th>E-mail</th>
            <th></th>
        </tr>
        @foreach($users as $account)
            <tr>
                <td>
                    <a href="{{ route('users.edit',$account->id)}}">
                        {{$account->name}}
                    </a>
                </td>
                <td>{{$account->middlename}}</td>
                <td>{{$account->lastname}}</td>
                <td>{{$account->phonenumber}}</td>
                <td>{{$account->email}}</td>
                <td class="no-link">
                    <form action="{{ route('users.destroy', $account->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" type="submit"
                                onclick="return confirm('Weet je zeker dat je deze gebruiker wilt verwijderen?')">
                            Verwijder
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    <div id="add-user-container">
        <form action="{{ route('users.create') }}">
            <button class="regular-btn">Voeg een nieuwe medewerker toe!</button>
        </form>
    </div>

@endsection
