@extends ('layouts.main')

@section ('content')
    <link href="{{ asset('/css/Application.css')}}" rel="stylesheet" type="text/css" media="all"/>
    <main>
        <h2>Help zelf ook mee!</h2>
        <div class="container">
            <div class="doSomething">
                @if($vacancy->picture != null)
                    <img src="{{ asset($vacancy->picture) }}" class="doSomething-image">
                @else
                    <img src="{{ URL::asset('img/Activity-placeholder.png') }}" class="doSomething-image">
                @endif
                <div class="content-container">
                    <p class="doSomething-header title">{{ $vacancy->title }}</p>
                    @if($vacancy->activity_planned_id != null)
                        <p class="doSomething-header date no-margin">{{ $vacancy->start_datetime->format('d-m-Y') }}</p>
                        <p class="semi-bold">{{ $vacancy->start_datetime->format('H:i') }}
                            - {{ $vacancy->end_datetime->format('H:i') }}</p>
                    @endif
                    @if(count($campingbazen) > 0)
                        <p class="doSomething-header no-margin">Campingbazen:</p>

                        <div class="campingbazen">
                            @foreach($campingbazen as $campingbaas)
                                @if(!$loop->last)
                                    <label class="doSomething-content campingbaas">{{ $campingbaas->firstname }}, </label>
                                @else
                                    <label class="doSomething-content campingbaas">{{ $campingbaas->firstname }} </label>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <br />
                    <p class="doSomething-content">{{ $vacancy->description }}</p>
                </div>
            </div>
            <div class="mainContainer" style="min-height:500px">
                <form class="applicaiton-form" method="post" action="{{ route('applications.store') }}">
                    @csrf
                    <input name="id" type="hidden" value="{{$id}}">
                    <div class="input-container">
                        <div class="content">

                            <div class="questionBox">
                                <span>Voornaam</span><br/>
                                <input placeholder="Vul voornaam in" type="name" name="firstname" value="{{ old('firstname')}}" required/>
                                @error('firstname')
                                <p class="formError">{{ $errors->first('firstname') }}</p>
                                @enderror
                            </div>

                            <div class="questionBox">
                                <span>Tussenvoegsel</span><br/>
                                <input placeholder="Vul tussenvoegsel in" type="middlename" name="middlename" value="{{ old('middlename')}}"/>
                                @error('middlename')
                                <p class="formError">{{ $errors->first('middlename') }}</p>
                                @enderror
                            </div>

                            <div class="questionBox">
                                <span>Achternaam</span><br/>
                                <input placeholder="Vul achternaam in" type="lastname" name="lastname" value="{{ old('lastname')}}" required/>
                                @error('lastname')
                                <p class="formError">{{ $errors->first('lastname') }}</p>
                                @enderror
                            </div>

                            <div class="questionBox">
                                <span>E-mail</span><br/>
                                <input placeholder="Vul E-mail in" type="email" name="email" value="{{ old('email')}}" required/>
                                @error('email')
                                <p class="formError">{{ $errors->first('email') }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="content">
                            <div class="questionBox">
                                <span>Telefoonnummer</span><br/>
                                <input placeholder="Vul telefoonnummer in" type="phonenumber" name="phonenumber" value="{{ old('phonenumber')}}"/>
                                @error('phonenumber')
                                <p class="formError">{{ $errors->first('phonenumber') }}</p>
                                @enderror
                            </div>
                            <div class="questionBox text-area-container">
                                <span>Waarom wil je helpen?</span><br/>
                                <textarea required placeholder="Vul in waarom je wilt helpen" class="text-area" name="application_letter"
                                >{{ old('application_letter')}}</textarea>
                                @error('application_letter')
                                <p class="formError">{{ $errors->first('application_letter') }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <input class="submit" type="submit" value="Help mee!"/>
                </form>


            </div>
        </div>

    </main>
    <br/>
    <br/>

@endsection
