@extends ('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/Homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/DonationOverview.css') }}">
    <link href="{{ asset('/css/Application.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section ('content')
    <br>
    <h1 class="initiative-header">Doneren</h1>
    <p class="donation-header">
        Om de camping draaiende te houden zijn wij afhankelijk van donaties, hieronder vindt u een
        lijstje van mogelijke donaties waarmee u camping de koffietent kan helpen. U kunt helpen op twee
        manieren, <a href="#donations" style="color:#48618a">donatie doelen</a> en <a href="#money" style="color:#48618a">geld donaties</a>
    </p>
    <hr>
    <br><br>

    <div class="search-upcoming-container">
        <div class="search-container">

            <form method="GET" action="{{route('donation-overview-search')}}">
                @csrf
                <p class="searchByText-header">Zoek op trefwoord</p>
                <div class="search-input">
                    <label>
                        <input type="text" name="searchText" class="search-bar" placeholder="&#xF002; Zoek"
                               value="{{request('searchText')}}">
                        <button type="submit" name="action" value="searchByText" id="search"> ></button>
                    </label>
                </div>
                <p class="searchByDate-header">Of sorteer op type</p>
                <div class="search-input">
                    <label>
                        <select class="search-bar" name="searchType">
                            <option selected>Geen</option>
                            <option value="Product">Product</option>
                            <option value="Euro">Geld</option>
                        </select>
                        <button type="submit" name="action" value="searchByDate"> ></button>
                    </label>
                </div>
            </form>
        </div>

        <div class="activity-container" id="donations">
            <p class="content-header">Donatie doelen</p>
            <div class="activity-container-border">

                @foreach ($donationTarget as $donationtarget)
                    @if($donationtarget->apid == null)
                        <div class="activity">
                            <img src="{{asset('/img/activityDisplayPicture/activity_placeholder.jpeg')}}" 

                                 alt="Activiteit">
                            <div class="activity-description activity-description-vacancy single" >
                                <p class="activity-description-header">{{$donationtarget->title}}</p>
                                <p class="activity-description-content">
                                    {{$donationtarget->description}}
                                </p>
                                <p class="activity-collected">
                                    We hebben
                                    @if($donationtarget->donation_item==="Euro")
                                        €{{$donationtarget->donation_received}} van de €{{$donationtarget->donation_needed}} opgehaald
                                    @else
                                        {{$donationtarget->donation_received}} van de {{$donationtarget->donation_needed}} opgehaald
                                    @endif
                                </p>
                            </div>

                            @if($donationtarget->donation_item==="Euro")
                                <a class="application-link planned"
                                   href="{{route('donation-money', $donationtarget->dtid)}}">
                                    <div class="activity-vacancy-button">
                                        <p class="activity-vacancy-button-content">Doneer!</p>
                                    </div>
                                </a>
                            @else
                                <a class="application-link planned"
                                   href="{{route('donation-product', $donationtarget->dtid)}}">
                                    <div class="activity-vacancy-button">
                                        <p class="activity-vacancy-button-content">Doneer!</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="activity">
                            <img src="{{asset($donationtarget->display_picture)}}" 
                                 alt="Activiteit">
                            <div class="activity-description activity-description-vacancy">
                                <p class="activity-description-header">{{$donationtarget->title}}</p>
                                <p class="activity-description-content">
                                    {{$donationtarget->description}}
                                </p>
                                <p class="activity-collected">
                                    We hebben
                                        @if($donationtarget->donation_item==="Euro")
                                            €{{$donationtarget->donation_received}} van de €{{$donationtarget->donation_needed}} opgehaald
                                        @else
                                            {{$donationtarget->donation_received}} van de {{$donationtarget->donation_needed}} opgehaald
                                        @endif
                                </p>
                            </div>
                            <div class="activity-details">
                                <p class="activity-description-header"><a href="{{route('initiativeDetails', $donationtarget->apid)}}">{{$donationtarget->name}}</a></p>
                                <p class="activity-date margin-top">{{\Carbon\Carbon::parse($donationtarget->start_datetime)->format('d-m-Y')}}</p>
                                <p class="activity-date">{{\Carbon\Carbon::parse($donationtarget->start_datetime)->format('H:i')}} - {{\Carbon\Carbon::parse($donationtarget->end_datetime)->format('H:i')}}</p>

                            </div>

                            @if($donationtarget->donation_item==="Euro")
                                <a class="application-link planned"
                                   href="{{route('donation-money', $donationtarget->dtid)}}">
                                    <div class="activity-vacancy-button">
                                        <p class="activity-vacancy-button-content">Doneer!</p>
                                    </div>
                                </a>
                            @else
                                <a class="application-link planned"
                                   href="{{route('donation-product', $donationtarget->dtid)}}">
                                    <div class="activity-vacancy-button">
                                        <p class="activity-vacancy-button-content">Doneer!</p>
                                    </div>
                                </a>
                            @endif
                        </div>
                    @endif
                @endforeach
                <div class="pagination" id="finished-activities-jump-section">
                    {{$donationTarget->fragment("search-paginate-jump-section")->appends(request()->input())->links()}}
                </div>
            </div>
        </div>
    </div>
    <br />

    <br /> <br />
    <br /> <br />
    <hr >
    <br id="money"/>
    <br />
    <main>
        <p class="content-header" >Doneer een bedrag</p>
        <div class="container">
            <div class="mainContainer normalContainer" style="min-height:470px">
                <form class="applicaiton-form" method="post" action="{{ route('donation-money-store') }}">
                    @csrf

                    <div class="input-container" >
                        <div class="content">
                            <div class="questionBox">
                                <span>Hoeveel wil je doneren?</span><br/>
                                <input placeholder="€" required type="text" min="€0.01" name="amount" value="{{ old('amount')}}"/>
                                @error('amount')
                                <p class="formError">{{ $errors->first('amount') }}</p>
                                @enderror
                            </div>
                            <div class="questionBox text-area-container">
                                <span>Waarom wil je doneren?</span><br/>
                                <textarea required placeholder="Is er een reden voor je donatie?"  style="height: 201px;" class="text-area" name="reason"
                                >{{ old('reason')}}</textarea>
                                @error('reason')
                                <p class="formError">{{ $errors->first('reason') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="content">
                            <div class="questionBox">
                                <span>Blijf je liever anoniem?</span><br/>
                                <div class="questionAnom">
                                    <p class="textAnom">Anoniem blijven:</p>
                                    <input type="checkbox"  name="anom" onchange="checkboxChanged(this)" />
                                </div>
                            </div>

                            <div class="questionBox name">
                                <span>Voornaam</span><br/>
                                <input placeholder="Voornaam"  type="name" name="firstname" style="opacity:1.0" value="{{ old('firstname')}}" required/>
                                @error('firstname')
                                <p class="formError">{{ $errors->first('firstname') }}</p>
                                @enderror
                            </div>

                            <div class="questionBox name">
                                <span>Tussenvoegsel</span><br/>
                                <input placeholder="Tussenvoegsel" type="middlename" name="middlename" value="{{ old('middlename')}}"/>
                                @error('middlename')
                                <p class="formError">{{ $errors->first('middlename') }}</p>
                                @enderror
                            </div>

                            <div class="questionBox name">
                                <span>Achternaam</span><br/>
                                <input placeholder="Achternaam" type="lastname"  name="lastname" value="{{ old('lastname')}}" required/>
                                @error('lastname')
                                <p class="formError">{{ $errors->first('lastname') }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <input class="submit buttonMoney" type="submit" value="Doneren"/>
                </form>


            </div>
        </div>

    </main>
    <script src="{{ asset('/js/Donationanonymous.js') }}" defer></script>

    <br>
    <br><br>
@endsection
