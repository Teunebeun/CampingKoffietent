@extends('layouts.cms')

@section('css')
    <link href="{{ asset('css/CMS/Activities.css') }}" rel="stylesheet">
@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="{{ asset('/js/cms/TableClickable.js') }}" defer></script>
@endsection

@section('page-title')
    Sponsoren & partners
@endsection

@section('content')

    <table class="table">
        <tr>
            <th>Naam</th>
            <th></th>
        </tr>
        @foreach ($sponsors as $sponsor)
            <tr>
                <td>
                    <a href="{{ route('cms-sponsor.edit',$sponsor->id)}}">
                        {{$sponsor->name}}
                    </a>
                </td>
                <td class="no-link">
                    <form action="{{ route('cms-sponsor.destroy', $sponsor->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="delete-btn" type="submit"
                                onclick="return confirm('Weet je zeker dat je deze sponsor/partner wilt verwijderen?')">
                            Verwijder
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach

    </table>
    <br>
    <div class="button-container">
        <form action="{{ route('cms-sponsor.create') }}">
            <button class="regular-btn">Voeg een nieuwe sponsor/partner toe!</button>
        </form>
    </div>

@endsection
