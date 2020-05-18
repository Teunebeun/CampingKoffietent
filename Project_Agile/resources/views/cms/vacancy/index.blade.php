@extends('layouts.cms')

@section('css')
    <link href="{{asset('css/cms/donations.css')}}" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ asset('js/CMS/dynamicToolTip.js') }}"></script>
@endsection

@section('page-title')
    Vacatures
@endsection

@section('content')
    <div class="container center">
        <div class="column1">
            <h1>Vacatures</h1>


            @if(count($vacancies) || request('searchVacancy'))
                <div class="search-wrapper">
                    <form action="{{ route('cms-vacancy') }}">
                        <label for="searchVacancy">Zoeken:</label>
                        <input type="text" name="searchVacancy" placeholder="&#xF002; Zoek..." value="{{ request('searchVacancy') ?? '' }}">
                        <button type="submit"> > </button>
                    </form>
                </div>
            @endif
            @if(count($vacancies))
                <table class="table">
                    <tr>
                        <th class="truncated">Naam</th>
                        <th class="truncated">Datum</th>
                        <th class="truncated">Reacties</th>
                        <th></th>
                    </tr>

                    @foreach($vacancies as $vacancy)
                        <tr>
                            <td class="truncated">
                                <a href="{{ route('cms-vacancy.edit', $vacancy->id)}}">
                                    {{$vacancy->title}}
                                </a>
                            </td>
                            <td class="truncated">
                                {{$vacancy->startDateFormatted() ?? "-" }}
                            </td>
                            <td class="truncated">
                                {{$vacancy->applicationAmount()}}
                            </td>
                            <td class="truncated no-link">
                                <form action="{{ route('cms-vacancy.destroy', $vacancy->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete" type="submit"
                                            onclick="return confirm('Weet je zeker dat je deze vacature wilt verwijderen?')">
                                        Verwijder
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="pagination">
                    {{ $vacancies->appends(request()->input())->links() }}
                </div>
            @else
                @if(request('searchVacancy'))
                    <p class="info">Er zijn geen vacatures die aan de zoekterm <i>"{{ request('searchVacancy') }}"</i> voldoen!</p>
                @else
                    <p class="info">Momenteel staan zijn er geen vacatures!</p>
                @endif
            @endif
            <a href="{{ route('cms-vacancy.create') }}">
                <button class="regular-btn btn-left">Voeg een nieuwe vacature toe!</button>
            </a>
        </div>
        <div class="column2">
            <h1>Aanmeldingen</h1>

            @if(count($applications) || request('searchApplication'))
                <div class="search-wrapper">
                    <form action="{{ route('cms-vacancy') }}">
                        <label for="searchApplication">Zoeken:</label>
                        <input type="text" name="searchApplication" placeholder="&#xF002; Zoek..." value="{{ request('searchApplication') ?? '' }}">
                        <button type="submit" value="" id=""> > </button>
                    </form>
                </div>
            @endif
            @if(count($applications))
                <table class="table">
                    <tr>
                        <th>Naam</th>
                        <th>Vacature</th>
                        <th></th>
                    </tr>
                    @foreach($applications as $application)
                        <tr>
                            <td class="truncated">
                                <a href="{{ route('cms-vacancy.show', $application->id) }}">
                                    {{$application->firstname . " " . $application->middlename . " " . $application->lastname}}
                                </a>
                            </td>
                            <td class="truncated">
                                {{$application->vacancy->title . ($application->vacancy->vacancy_filled ? '(vol)':'')}}
                            </td>
                            <td class="truncated no-link">
                                <form action="{{ route('cms-vacancyApplication.destroy', $application->id)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="delete" type="submit"
                                            onclick="return confirm('Weet je zeker dat je deze aanmelding wilt verwijderen?')">
                                        Verwijder
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                <div class="pagination">
                    {{ $applications->appends(request()->input())->links() }}
                </div>
            @else
                @if(request('searchApplication'))
                    <p class="info">Er zijn geen aanmeldingen die aan de zoekterm <i>"{{ request('searchApplication') }}"</i> voldoen!</p>
                @else
                    <p class="info">Alle aanmeldingen zijn bijgewerkt!</p>
                @endif
            @endif
        </div>
    </div>
@endsection

