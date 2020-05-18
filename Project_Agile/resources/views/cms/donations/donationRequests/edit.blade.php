@extends('layouts.cms')

@section('css')
    <link href="{{asset('css/cms/donations.css')}}" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection

@section('page-title')
    Donaties
@endsection

@section('content')
    <div class="header-wrapper">
        <h1>Donatie Bewerken</h1>
    </div>

    <div class="container">
        <div class="column1">
            <h2>Aanvraag</h2>
            <form class="request" action="{{ route('donationRequest.update', $donationTarget->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label for="title">Titel:</label>
                <input type="text" name="title" value="{{$donationTarget->title}}" placeholder="Titel" required/>
                @error('title')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <label for="donation_item">Voorwerp:</label>
                <input type="voorwerp" name="donation_item" value="{{$donationTarget->donation_item}}" placeholder="Welk voorwerp wil je aanvragen?" required/>
                @error('donation_item')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <label for="donation_needed">Aantal:</label>
                <input type="number" name="donation_needed" value="{{$donationTarget->donation_needed}}" min="0" max="99999999.99" step="0.01" placeholder="Aantal" required/>
                @error('donation_needed')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <label for="description">Beschrijving:</label>
                <textarea name="description" placeholder="Vul hier een beschrijving in..." required>{{$donationTarget->description}}</textarea>
                @error('description')
                <p class="error">
                    {{ $message }}
                </p>
                @enderror

                <div class="button-wrapper">
                    <button type="button" onclick="location.href = '{{ route('donations.index') }}';" class="delete-btn">Annuleren</button>
                    <button class="regular-btn">Opslaan</button>
                </div>
            </form>
        </div>
        <div class="column2">
            <h2>Donaties</h2>

            @if(count($donations) > 0 || request('search_donators'))
            <div class="search-wrapper">
                <form>
                    <label for="search_donators">Zoeken:</label>
                    <input type="text" name="search_donators" placeholder="&#xF002; Zoek in donatiebeschrijving..." value="">
                    <button type="submit" value="" id=""> > </button>
                </form>
            </div>

            @if(request('search_donators') && count($donations) === 0)
                <p>Geen van de donaties bevat '{{ request('search_donators') }}' in de beschrijving!</p>
            @endif

            @if(count($donations) > 0)
            <table class="table">
                <tr>
                    <th>
                        Naam
                    </th>
                    <th>
                        Datum
                    </th>
                    <th>
                        {!! ($donationTarget->donation_item === "Euro") ? 'Bedrag' : 'Aantal' !!}
                    </th>
                    <th>
                        Ontvangen
                    </th>
                </tr>
                @foreach($donations as $donation)
                    <tr>
                        <td class="truncated">
                            <a href="{{ route('donations.show', $donation['id']) }}">
                                {{$donation['fullName']}}
                            </a>
                        </td>
                        <td class="truncated">
                            {{$donation['date']->format('Y-m-d')}}
                        </td>
                        <td class="truncated">
                            {!! ($donationTarget->donation_item === "Euro") ? '&#8364; ' . $donation['amount'] : $donation['amount'] + 0 !!}
                        </td>
                        <td>
                            @if($donation['received'])
                            <i class="fa">&#xF00c;</i>
                            @else
                            <i class="fa">&#xF057;</i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="pagination">
                {{ $donations->links() }}
            </div>
            @endif
            @else
            <p>
                Er zijn geen niet-verwerkte donaties voor deze aanvraag.
            </p>
            @endif
        </div>
    </div>
@endsection
