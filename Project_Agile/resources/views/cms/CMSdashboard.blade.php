@extends('layouts.cms')

    @section('css')
        <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/Dashboard.css') }}">
    @endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="{{ asset('/js/cms/TableClickable.js') }}" defer></script>
@endsection

@section('page-title')
    Dashboard
@endsection

@section('content')
    <div id="content-container">
        <div class="column">
            <div class="small-row">
                <div class="small-box">
                    <div class="small-box-text">
                        <table>
                            <tr>
                                <th colspan="3">
                                    Vandaag op de agenda
                                </th>
                            </tr>
                            @forelse ($todays_activities as $activity)
                                <tr class="clickable-tr">
                                    <td>
                                        <a href="{{ route('schedule-edit', $activity->id) }}">
                                            {{ \Carbon\Carbon::parse($activity->start_datetime)->format('H:i') }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($activity->end_datetime != null)
                                            {{ \Carbon\Carbon::parse($activity->end_datetime)->format('H:i') }}
                                        @else
                                            --:--
                                        @endif
                                    </td>
                                    <td>
                                        {{ $activity->name }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td rowspan="3">
                                        Er zijn geen initiatieven vandaag
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
                <div class="small-box">
                    <div class="small-box-text">
                        <table>
                            <tr>
                                <th colspan="3">
                                    Morgen op de agenda
                                </th>
                            </tr>
                            @forelse ($tomorrows_activities as $activity)
                                <tr class="clickable-tr">
                                    <td>
                                        <a href="{{ route('schedule-edit', $activity->id) }}">
                                            {{ \Carbon\Carbon::parse($activity->start_datetime)->format('H:i') }}
                                        </a>
                                    </td>
                                    <td>
                                        @if ($activity->end_datetime != null)
                                            {{ \Carbon\Carbon::parse($activity->end_datetime)->format('H:i') }}
                                        @else
                                            --:--
                                        @endif
                                    </td>
                                    <td>
                                        {{ $activity->name }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td rowspan="3">
                                        Er zijn geen initiatieven morgen
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

            <div class="big-row">
                <div class="big-box">
                    <div class="big-box-text">
                        <table>
                            <tr>
                                <th colspan="3">
                                    Nieuwe voorgestelde initiatieven
                                </th>
                            </tr>
                            @forelse($new_initiatives as $initiative)
                                <tr class="clickable-tr">
                                    <td>
                                        <a href="{{ route('send_initiative.show', $initiative->id) }}">
                                            {{ $initiative->title }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($initiative->datetime)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        {{
                                            $initiative->initiator->name
                                            . ' '
                                            . $initiative->initiator->middlename
                                            . ' '
                                            . $initiative->initiator->lastname
                                        }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td rowspan="3">
                                        Er zijn geen nieuwe initiatieven
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            @endforelse
                            <tr>
                                <td colspan="3" class="no-link">
                                    <div class="pagination">
                                        {{ $new_initiatives->links() }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="small-row">
                <div class="small-box">
                    <div class="small-box-text">
                        <table>
                            <tr>
                                <th colspan="2">
                                    Nieuwste initiatieven
                                </th>
                            </tr>
                            @forelse($last_added as $last)
                                <tr class="clickable-tr">
                                    <td>
                                        <a href="{{ route('schedule-edit', $last->id) }}">
                                            {{ $last->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($last->creation_datetime)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td rowspan="3">
                                        Er zijn geen activiteiten laatst toegevoegd
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
                <div class="small-box">
                    <div class="small-box-text">
                        <table>
                            <tr>
                                <th colspan="2">
                                    Recente donaties
                                </th>
                            </tr>
                            @forelse($recent_donations as $donation)
                                <tr class="clickable-tr">
                                    <td>
                                        <a href="{{ route('donations.show', $donation->id) }}">
                                            @if(is_null($donation->donator_name))
                                                Anoniem
                                            @else
                                                {{
                                                    $donation->donator_name
                                                    . ' '
                                                    . $donation->donator_middlename
                                                    . ' '
                                                    . $donation->donator_lastname
                                                }}
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        @if(is_null($donation->donationtarget->Activity_Planned_id))
                                            Algemene donatie
                                        @else
                                            {{
                                                $donation->donationtarget->activityplanned->name
                                            }}
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td rowspan="3">
                                        Er zijn geen recente donaties
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                            @endforelse
                        </table>
                    </div>
                </div>
            </div>

            <div class="big-row">
                <div class="big-box">

                    <div class="big-box-text">
                        <table>
                            <tr>
                                <th colspan="3">
                                    Nieuwe aanmelding vacatures
                                </th>
                            </tr>
                            @forelse($new_applications as $application)
                                <tr class="clickable-tr">
                                    <td>
                                        {{ $application->vacancy->title }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($application->datetime)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('cms-vacancy.show', $application->id) }}">
                                            {{
                                                $application->firstname
                                                . ' '
                                                . $application->middlename
                                                . ' '
                                                . $application->lastname
                                            }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td rowspan="5">
                                        Er zijn geen nieuwe aanmeldingen
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                                <tr></tr>
                            @endforelse
                            <tr class="paginate">
                                <td colspan="3" class="no-link">
                                    <div class="pagination">
                                        {{ $new_applications->links() }}
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
