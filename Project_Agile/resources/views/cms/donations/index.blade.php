@extends('layouts.cms')

@section('css')
    <link href="{{asset('css/cms/donations.css')}}" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="{{ asset('js/CMS/dynamicToolTip.js') }}"></script>
@endsection

@section('page-title')
    Donaties
@endsection

@section('content')
    <div class="container center">
        <div class="column1">
            <h1>Gevraagde donaties</h1>


            @if(count($donationTargets) || request('search_requests'))
                <div class="search-wrapper">
                    <form action="{{ request()->fullUrl() }}">
                        <label for="search_donators">Zoeken:</label>
                        <input type="text" name="search_requests" placeholder="&#xF002; Zoek..." value="{{ request('search_requests') ?? '' }}">
                        <button type="submit"> > </button>
                    </form>
                </div>
            @endif
            @if(count($donationTargets))
            <table class="table">
                <tr>
                    <th class="truncated">Naam</th>
                    <th class="truncated">Datum</th>
                    <th class="truncated">Voortgang</th>
                    <th></th>
                </tr>

                @foreach($donationTargets as $target)
                    <tr>
                        <td class="truncated">
                            <a href="{{ route('donationRequest.edit', $target['id'])}}">
                                {{ $target->title }}
                            </a>
                        </td>
                        <td class="truncated" title="{{ $target->datetime->format('Y-m-d') }}">
                            {{ $target->datetime->format('Y-m-d') }}
                        </td>
                        <td class="truncated">
                            @if($target->donation_item === "Euro")
                                &#8364; {{ $target->donation_received.(($target->donation_needed === "0.00") ? '' :  ' / ' . $target->donation_needed) }}
                            @else
                                {{ ($target->donation_received + 0).(($target->donation_needed === "0.00") ? '' :  ' / ' . ($target->donation_needed + 0)) }}
                            @endif
                        </td>
                        <td class="truncated no-link">
                            <form action="{{route('donationRequest.destroy', $target['id'])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit"
                                        onclick="return confirm('Weet je zeker dat je deze donatie-aanvraag wilt verwijderen? Hiermee verwijder je ook alle donaties die aan deze aanvraag gekoppeld zijn.')">
                                    Verwijder
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination">
                {{ $donationTargets->appends(Illuminate\Support\Facades\Request::except('requestPage'))->links() }}
            </div>
            @else
                @if(request('search_requests'))
                    <p class="info">Er zijn geen donatie-aanvragen die aan de zoekterm <i>"{{ request('search_requests') }}"</i> voldoen!</p>
                @else
                    <p class="info">Momenteel staan er geen donatie-aanvragen open!</p>
                @endif
            @endif
            <a href="{{ route('donationRequest.create') }}">
                <button class="regular-btn btn-left">Nieuwe donatie aanvraag</button>
            </a>
        </div>
        <div class="column2">
            <h1>Aangeboden donaties</h1>

            @if(count($donations) || request('search_donators'))
            <div class="search-wrapper">
                <form action="{{ request()->fullUrl() }}">
                    <label for="search_donators">Zoeken:</label>
                    <input type="text" name="search_donators" placeholder="&#xF002; Zoek..." value="{{ request('search_donators') ?? '' }}">
                    <button type="submit" value="" id=""> > </button>
                </form>
            </div>
            @endif
            @if(count($donations))
            <table class="table">
                <tr>
                    <th>Naam</th>
                    <th>Donatie Aanvraag</th>
                    <th></th>
                </tr>
                @foreach($donations as $donation)
                    <tr>
                        <td class="truncated">
                            <a href="{{ route('donations.show', $donation['id']) }}">
                                {{ $donation['fullName'] }}
                            </a>
                        </td>
                        <td class="truncated">
                            {{ $donation['description'] }}
                        </td>
                        <td class="truncated no-link">
                            <form action="{{ route('donations.destroy', $donation['id'])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="delete" type="submit"
                                        onclick="return confirm('Weet je zeker dat je deze donatie uit het systeem wilt verwijderen?')">
                                    Verwijder
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination">
                {{ $donations->appends(Illuminate\Support\Facades\Request::except('donationPage'))->links() }}
            </div>
            @else
                @if(request('search_donators'))
                    <p class="info">Er zijn geen donaties die aan de zoekterm <i>"{{ request('search_donators') }}"</i> voldoen!</p>
                @else
                    <p class="info">Alle donaties zijn bijgewerkt!</p>
                @endif
            @endif
        </div>
    </div>
@endsection
