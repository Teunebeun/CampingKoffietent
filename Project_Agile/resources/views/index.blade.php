@extends('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/Homepage.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section('content')

    <img src="{{ asset($info->homepage_picture) }}" alt="hoofdpagina foto" id="Homepage-picture">

    <div class="Homepage-text-container">
        <p><b>{{ $info->homepage_title }}</b></p>
        <p>
            {{ $info->homepage_text }}
        </p>
    </div>



    <p class="big-header big-header-top" id="doe-mee">Doe mee!</p>
    <div class="doSomething-container">
        <div class="doSomething">
            <img src="{{ asset($info->coffee_picture) }}" class="doSomething-image">
            <p class="doSomething-header">{{ $info->coffee_title }}</p>
            <p class="doSomething-content">{{ $info->coffee_text }}</p>
            <button class="doSomething-button">{{ $info->coffee_button }}</button>
        </div>
        <div class="doSomething">
            <img src="{{ asset($info->activity_picture) }}" class="doSomething-image">
            <p class="doSomething-header">{{ $info->activity_title }}</p>
            <p class="doSomething-content">{{ $info->activity_text }}</p>
            <a href="{{ url('initiatief/nieuw') }}">
                <button class="doSomething-button">{{ $info->activity_button }}</button>
            </a>
        </div>
        <div class="doSomething">
            <img src="{{ asset($info->help_picture) }}" class="doSomething-image">
            <p class="doSomething-header">{{ $info->help_title }}</p>
            <p class="doSomething-content">{{ $info->help_text }}</p>
            <a href="{{ url('initiatief') }}">
                <button class="doSomething-button">{{ $info->help_button }}</button>
            </a>
        </div>
        <div class="doSomething">
            <img src="{{ asset($info->donate_picture) }}" class="doSomething-image">
            <p class="doSomething-header">{{ $info->donate_title }}</p>
            <p class="doSomething-content">{{ $info->donate_text }}</p>
            <a href="{{route('donation-overview')}}">
                <button class="doSomething-button">{{ $info->donate_button }}</button>
            </a>
        </div>
    </div>

    <br><br id="search-paginate-jump-section"><br><br>


    <div class="search-upcoming-container">
        <div class="activity-container">
            <p class="content-header">Aankomende initiatieven</p>
            <div class="activity-container-border">
                @forelse ($upcomingActivities as $upcomingActivity)

                    @if ($upcomingActivity->id == 1)
                        <div class="activity activity-special">
                            <img src="{{asset($upcomingActivity->display_picture)}}" class="activity-image"
                                 alt="Activiteit">
                            <div class="activity-description activity-description-special">
                                <p class="activity-description-header activity-description-more-white">{{$upcomingActivity->name}}</p>
                                <p class="activity-description-content activity-description-more-white">
                                    @if (strlen($upcomingActivity->description) >= 200)
                                        {{substr($upcomingActivity->description,0,200)}}...
                                    @else
                                        {{$upcomingActivity->description}}
                                    @endif
                                </p>
                                <p class="activity-description-more">
                                    <a href="{{url('openingstijden')}}" class="activity-description-more-white">
                                        Check hier of we open zijn
                                    </a>
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="activity">
                            <img src="{{asset($upcomingActivity->display_picture)}}" class="activity-image"
                                 alt="Activiteit">
                            <div class="activity-details">
                                <p class="activity-date">{{explode(' ', $upcomingActivity->startDateFormatted())[0]}}</p>
                                <p class="activity-time">{{explode(' ', $upcomingActivity->startDateFormatted())[1]}}</p>
                                <p class="activity-campingbaas-header">Campingbaas:</p>
                                <p class="activity-campingbaas">
                                    @foreach ($upcomingActivity->campingbazen as $campingbaas)
                                        {{$campingbaas->firstname}}
                                    @endforeach</p>
                                @if($upcomingActivity->filled)
                                    <a href="{{url('openingstijden')}}">Kom langs!</a>
                                @else
                                    <a href="{{route('applications.create', \App\Vacancy::where('activity_planned_id', '=', $upcomingActivity->id)->pluck('id')->first())}}">Help
                                        mee!</a>
                                @endif

                            </div>
                            <div class="activity-description">
                                <p class="activity-description-header">{{$upcomingActivity->name}}</p>
                                <p class="activity-description-content">
                                    @if (strlen($upcomingActivity->description) >= 150)
                                        {{substr($upcomingActivity->description,0,150)}}...
                                    @else
                                        {{$upcomingActivity->description}}
                                    @endif
                                </p>
                                <p class="activity-description-more"><a
                                        href="{{ route('initiativeDetails', $upcomingActivity->id) }}">lees meer</a></p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="activity">
                        <img src="{{ asset('/img/activityDisplayPicture/activity_placeholder.jpeg') }}"
                             class="activity-image">
                        <div class="activity-description empty-activity-description">
                            <p class="activity-description-header">We hebben momenteel geen initiatieven ingepland</p>
                            <p class="activity-description-content">Wil jij koffie schenken? Of heb jij een leuk idee?
                                <a href="{{ url('initiatief') }}"><b>Laat het ons weten!!</b></a>
                            </p>
                        </div>
                    </div>
                @endforelse
                <div class="pagination" id="finished-activities-jump-section">
                    {{$upcomingActivities->fragment("search-paginate-jump-section")->appends(request()->input())->links()}}
                </div>
            </div>
        </div>

        @if($instagramPost)
        <div id="insta-div">
            <div class="insta-media">
                @if ($instagramPost['media_type'] == 'VIDEO')
                    <button id="insta-vid-button" class="insta-media">
                        <div id="insta-vid-wrapper">
                            <video id="insta-vid" class="insta-media">
                                <source src="{{$instagramPost['media_url']}}" type="video/mp4" class="insta-media">
                            </video>
                            <div id="insta-vid-overlay"></div>
                        </div>
                    </button>
                @elseif ($instagramPost['media_type'] == 'IMAGE' || $instagramPost['media_type'] == 'CAROUSEL_ALBUM')
                    <img src="{{$instagramPost['media_url']}}" class="insta-media">
                @endif
            </div>
            <div id="insta-content">
                <div id="insta-content-header">
                    <img src="{{asset('/img/Insta_user_picture.png')}}" id="insta-user-image" class="col-sm">
                    <h4 id="insta-username">{{$instagramPost['username']}}</h4>
                </div>
                @if (array_key_exists("caption", $instagramPost))
                    <p id="insta-caption">{{$instagramPost['caption']}}</p>
                @endif
                <p id="insta-date">{{$instagramPost['timestamp']}}</p>
            </div>
        </div>
        @endif


    </div>
    <br><br><br>
    <hr>

    <p class="big-header">Sponsoren en partners</p>
    <div class="sponsor-container">
        @foreach($sponsors as $sponsor)
            <a href="{{ $sponsor->link }}">
                <img src="{{asset($sponsor->logo)}}" alt={{$sponsor->name}} title="{{$sponsor->description}}">
            </a>
        @endforeach
    </div>

    <script src="{{ asset('js/InstagramAPI.js') }}"></script>
@endsection
