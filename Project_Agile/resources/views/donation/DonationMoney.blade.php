@extends ('layouts.main')

@section('css')
    <link href="{{ asset('/css/Application.css')}}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    <main>
        <h2>Financiële bijdrage</h2>
        <div class="container">
            @if($activity===null)
                <div class="doSomething" style="min-height:500px">
                    <img src="{{asset('/img/activityDisplayPicture/activity_placeholder.jpeg')}}" class="doSomething-image">
                    <div class="content-container">
                        <p class="doSomething-header title" style="font-size:18px">{{ $donationTarget->title }}</p>

                        <p class="doSomething-content">{{ $donationTarget->description }}</p>
                        <br />
                        @if($donationTarget->donation_needed === null || $donationTarget->donation_needed == 0.0 || $donationTarget->donation_needed == 0)
                            <label class="doSomething-content campingbaas" style="font-size:18px;">We hebben al <b>€{{$donationTarget->donation_received}}</b> opgehaald. </label>
                        @else
                            <label class="doSomething-content campingbaas" style="font-size:18px;">We hebben nog <b>€{{$donationTarget->donation_needed - $donationTarget->donation_received}}</b> {{$donationTarget->donation_item}} nodig</label>
                        @endif
                    </div>
                </div>
            @else
                <div class="doSomething" style="min-height:500px">
                    @if($activity->display_picture != null)
                        <img src="{{ asset($activity->display_picture) }}" class="doSomething-image">
                    @else
                        <img src="{{ URL::asset('img/Activity-placeholder.png') }}" class="doSomething-image">
                    @endif
                    <div class="content-container">
                        <p class="doSomething-header title">{{ $activity->name }}</p>
                        <label class="doSomething-content campingbaas">{{ $activity->start_datetime->format('d-m-yy') }} </label>
                        <label class="doSomething-content campingbaas">{{ $activity->start_datetime->format('H:i') }} - {{ $activity->end_datetime->format('H:i') }} </label><br />

                        <p class="doSomething-header title" style="font-size:18px">{{ $donationTarget->title }}</p>

                        <p class="doSomething-content">{{ $donationTarget->description }}</p>
                        <br />
                        @if($donationTarget->donation_needed === null || $donationTarget->donation_needed == 0.0 || $donationTarget->donation_needed == 0)
                            <label class="doSomething-content campingbaas" style="font-size:18px;">We hebben al <b>€{{$donationTarget->donation_received}}</b> Opgehaald </label>
                        @else
                            <label class="doSomething-content campingbaas" style="font-size:18px;">We hebben nog <b>€{{$donationTarget->donation_needed - $donationTarget->donation_received}}</b> {{$donationTarget->donation_item}} nodig</label>
                        @endif
                    </div>
                </div>
            @endif

            <div class="mainContainer" style="min-height:500px">
                <form class="applicaiton-form" method="post" action="{{ route('donation-money-store') }}">
                    @csrf
                    <input name="id" type="hidden" required value="{{$donationTarget->id}}">

                    <div class="input-container">
                        <div class="content">
                            <div class="questionBox">
                                <span>Hoeveel wil je doneren?</span><br/>
                                <input placeholder="€" onchange="addEuro(this)"required type="text" name="amount" value="{{ old('amount')}}"/>
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
                    <input class="submit buttonMoney" type="submit"  value="Doneren"/>
                </form>


            </div>
        </div>

    </main>
    <br/>
    <br/>
    <script src="{{ asset('/js/Donationanonymous.js') }}" defer></script>
@endsection
