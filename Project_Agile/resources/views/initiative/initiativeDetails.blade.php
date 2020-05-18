@extends ('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/initiativeDetails.css') }}">
@endsection

@section('content')
    <div id="main-container">
        <p class="big-header bold">{{$initiative->name}}</p>
        <div id="blue">
            <div class="dates-div">
                <p class="medium-header text-white bold">
                    {{explode(' ', $initiative->startDateFormatted())[0]}}
                    <br>
                    {{explode(' ', $initiative->startDateFormatted())[1]}}

                    @if ($initiative->end_datetime)
                        - {{explode(' ', $initiative->endDateFormatted())[1]}}
                    @endif
                </p>
            </div>
            <div id="general-info" class="text-white">

                <div id="left">

                    <div class="flex inline-block center">

                        <div class="large-image-div center">
                            <img class="large-image" src="{{asset($initiative->display_picture)}}">
                        </div>

                        <p class="description center">{{$initiative->description}}</p>

                    </div>

                </div>
                <div id="right">
                    @if($creator != null)
                        <p class="text-blue larger-text bold">Initiatiefnemer:</p>
                        <div class="flex w30p">
                            <p class="medium-header text-blue bold w70">Campingbaas {{$creator->firstname}}</p>
                            <div class="small-image-div w30">
                                <img class="small-image" src="{{asset($creator->picture_small)}}">
                            </div>

                        </div>
                        <br>

                        <p class="text-blue larger-text bold">Helpers:</p>
                    @endif
                    @forelse ($initiative->campingbazen as $campingbaas)
                        <div class="flex w30p">
                            <p class="medium-header text-blue bold w70">Campingbaas {{$campingbaas->firstname}}</p>
                            <div class="small-image-div w30">
                                <img class="small-image" src="{{asset($campingbaas->picture_small)}}">
                            </div>
                        </div>
                    @empty
                        <p class="text-blue medium-header bold extend-bottom">Er zijn nog geen helpers</p>
                    @endforelse

                    @if($vacancy)
                        <div class="extend-top">
                            <a class="button-black medium-header"
                               href="{{route('applications.create', $vacancy->id)}}">Doe mee</a>
                        </div>

                    @endif
                </div>
            </div>
            <div id="donations">
                <p class="medium-header text-white bold">Help ons</p>
                <div class="flex">
                    @if($initiative->start_datetime < \Carbon\Carbon::now())
                        <div>
                            <p class="text-white medium-header">het initiatief is al afgelopen</p>
                        </div>
                    @else
                        @forelse($donations as $donation)
                            @if($donation->is_completed == 1)
                                <div class="completed-paginate-box">
                                    <p class="donated-header medium-header">Gedoneerd</p>
                                    <p class="donated medium-header">{{$donation->donation_item}}</p>
                                </div>
                            @else
                                <div class="paginate-box">
                                    @if($donation->donation_item === "Euro")
                                        <a href="{{route('donation-money', $donation->id)}}">
                                            <span class="link-text">{{$donation->title}}</span>
                                        </a>
                                    @else
                                        <a href="{{route('donation-product', $donation->id)}}">
                                            <span class="link-text">{{$donation->title}}</span>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @empty
                            <div>
                                <p class="text-white medium-header">er zijn geen openstaande donaties</p>
                            </div>
                        @endForelse
                    @endif
                </div>
                <div class="flex-right">
                    @if($donations->hasPages())
                        <div class="paginate-background">
                            {{$donations->fragment("donations")->links()}}
                        </div>
                    @endif
                </div>

            </div>
        </div>
        <div id="pictures">
            <p class="medium-header bold">Foto's</p>
            <div class="flex">
                @forelse($pictures as $picture)
                    <div class="paginate-box">
                        <a href="{{asset($picture->picture)}}" target="_blank">
                            <img class="img" src="{{asset($picture->picture)}}">
                        </a>
                    </div>
                @empty
                    <div>
                        <p class="small-header">er zijn nog geen foto's</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="flex-right">
            <div class="paginate-background">
                {{$pictures->fragment("pictures")->links()}}
            </div>
        </div>

    </div>
@endsection
