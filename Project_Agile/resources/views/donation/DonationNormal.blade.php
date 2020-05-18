@extends ('layouts.main')

@section('css')
    <link href="{{ asset('/css/Application.css')}}" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('content')
    <main>
        <h2>Financiële bijdrage</h2>
        <div class="container">
            <div class="mainContainer normalContainer" style="min-height:500px">
                <form class="applicaiton-form" method="post" action="{{ route('donation-money-store') }}">
                    @csrf

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
