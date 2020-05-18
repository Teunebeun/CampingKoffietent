@extends('layouts.cms')

@section('css')
    <link href="{{asset('css/cms/donations.css')}}" type="text/css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
@endsection

@section('page-title')
    Donaties
@endsection

@section('content')
    <h1>Aangeboden Donatie</h1>
    <div class="container auto">
        <div class="column1 auto" id="showDonation">
            <table class="listing">
                <tr>
                    <th>
                        Donatie Aanvraag:
                    </th>
                    <td>
                        {{ $donation->donationtarget->title }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Initiatief:
                    </th>
                    <td>

                        {!! $donation->donationtarget->Activity_Planned_id ? $donation->donationtarget->activityplanned->name : '<i>Niet gekoppeld aan een initiatief</i>' !!}

                    </td>
                </tr>
                <tr>
                    <th>
                        Voorwerp:
                    </th>
                    <td>
                        {{ $donation->donationtarget->donation_item }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Aantal nodig:
                    </th>
                    <td>
                        {!! ($donation->donationtarget->donation_needed === "0.00") ? '-' : $donation->donationtarget->donation_needed !!}
                    </td>
                </tr>
                <tr>
                    <th>
                        Startdatum aanvraag:
                    </th>
                    <td>
                        {{ $donation->donationtarget->datetime->format('Y-m-d') }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Datum aanbod:
                    </th>
                    <td>
                        {{ $donation->datetime->format('Y-m-d') }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="column2 auto">
            <table class="listing">
                <tr>
                    <th>
                        Naam:
                    </th>
                    <td>
                        {{$donation->donator_name == null ? 'Anoniem' : $donation->fullname() }}
                    </td>

                </tr>
                <tr>
                    <th>
                        E-mail:
                    </th>
                    <td>
                        {{ $donation->donator_email ?? 'Anoniem' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Telefoonnummer:
                    </th>
                    <td>
                        {{ $donation->donator_phonenumber ?? 'Anoniem' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Aantal aangeboden:
                    </th>
                    <td>
                        {{ $donation->donation_amount }}
                    </td>
                </tr>
                <tr>
                    <th>
                        Toelichting:
                    </th>
                    <td>
                        {{ $donation->description ?? 'Er is geen beschrijving beschikbaar.' }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @if($donation->is_received)
        <p>Deze donatie is reeds geaccepteerd</p>
    @else
        <div class="button-wrapper">
            <form action="{{ route('donations.destroy', $donation->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button class="delete-btn">Afwijzen</button>
            </form>
            <form action="{{ route('donations.accept', $donation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <button class="regular-btn">Accepteren</button>
            </form>
        </div>
    @endif
@endsection
