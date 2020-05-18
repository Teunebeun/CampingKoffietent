@extends ('layouts.main')

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/Homepage.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
@endsection

@section ('content')
    <br>
    <h1 class="initiative-header">Initiatieven</h1>

    <hr>
    <br>
    <div class="button-container" id="search-paginate-jump-section">
        <a href="{{ url('initiatief/nieuw') }}">
            <button>Begin een initiatief!</button>
        </a>
    </div>
    <br><br>

    <div class="search-upcoming-container">
        <div class="search-container">

            <form method="GET" action="{{route('initiative.search')}}">
                @csrf
                <p class="searchByText-header">Zoek op trefwoord</p>
                <div class="search-input">
                    <label>
                        <input type="text" name="searchText" class="search-bar" placeholder="&#xF002; Zoek"
                               value="{{request('searchText')}}">
                        <button type="submit" name="action" value="searchByText" id="search"> ></button>
                    </label>
                </div>
                <p class="searchByDate-header">Of zoek op datum</p>
                <div class="search-input">
                    <label>
                        <input type="date" name="searchDate" class="search-bar" value="{{request('searchDate')}}">
                        <button type="submit" name="action" value="searchByDate"> ></button>
                    </label>
                </div>
            </form>
        </div>

        <div class="activity-container">
            <p class="content-header">Aankomende initiatieven</p>
            <div class="activity-container-border">
                @forelse ($upcomingActivities as $upcomingActivity)

                    @if ($upcomingActivity->id == 1)
                        <div class="activity activity-special">
                            <img src="{{asset($upcomingActivity->display_picture)}}" class="activity-image"
                                 alt="Activiteit">
                            <div class="activity-description activity-description-special activity-description-vacancy">
                                <p class="activity-description-header activity-description-more-white">{{$upcomingActivity->name}}
                                </p>
                                <p class="activity-description-content activity-description-more-white">
                                    @if (strlen($upcomingActivity->description) >= 200)
                                        {{substr($upcomingActivity->description,0,200)}}...
                                    @else
                                        {{$upcomingActivity->description}}
                                    @endif
                                </p>
                                <p class="activity-description-more"><a href="{{url('openingstijden')}}"
                                                                        class="activity-description-more-white">Check
                                        hier
                                        of we open zijn</a></p>
                            </div>
                            <a href="{{url('openingstijden')}}" class="application-link planned">
                            <div class="activity-vacancy-button">
                                <p class="activity-vacancy-button-content">Kom langs!</p>
                            </div>
                            </a>
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
                            </div>
                            <div class="activity-description activity-description-vacancy">
                                <p class="activity-description-header">{{$upcomingActivity->name}}</p>
                                <p class="activity-description-content">
                                    @if (strlen($upcomingActivity->description) >= 150)
                                        {{substr($upcomingActivity->description,0,150)}}...
                                    @else
                                        {{$upcomingActivity->description}}
                                    @endif
                                </p>
                                <p class="activity-description-more"><a href="{{ route('initiativeDetails', $upcomingActivity->id) }}">lees meer</a></p>
                            </div>
                            @if($upcomingActivity->filled)
                            <a class="application-link planned" href="{{url('openingstijden')}}">
                                <div class="activity-vacancy-button">
                                    <p class="activity-vacancy-button-content">Kom langs!</p>
                                </div>
                            </a>
                            @else
                                <a class="application-link planned"
                                   href="{{route('applications.create', $upcomingActivity->vacancies->first()->id)}}">
                                    <div class="activity-vacancy-button">
                                        <p class="activity-vacancy-button-content">Help mee!</p>
                                    </div>
                                </a>
                            @endif

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
    </div>
    <br>
    <div class="search-upcoming-container">
        <div class="activity-container">
            <p class="content-header">Recente initiatieven</p>
            <div class="activity-container-border">
                @forelse ($finishedActivities as $finishedActivity)
                    <div class="activity">
                        <img src="{{asset($finishedActivity->display_picture)}}" class="activity-image">
                        <div class="activity-details">
                            <p class="activity-date">{{explode(' ', $finishedActivity->startDateFormatted())[0]}}</p>
                            <p class="activity-time">{{explode(' ', $finishedActivity->startDateFormatted())[1]}}</p>
                            <p class="activity-campingbaas-header">Campingbaas:</p>
                            <p class="activity-campingbaas">
                                @foreach ($finishedActivity->campingbazen as $campingbaas)
                                    {{$campingbaas->firstname}}
                                @endforeach
                            </p>
                        </div>
                        <div class="activity-description">
                            <p class="activity-description-header">{{$finishedActivity->name}}</p>
                            <p class="activity-description-content">
                                @if (strlen($finishedActivity->description) >= 200)
                                    {{substr($finishedActivity->description,0,200)}}...
                                @else
                                    {{$finishedActivity->description}}
                                @endif
                            </p>
                            <p class="activity-description-more"><a href="{{ route('initiativeDetails', $finishedActivity->id) }}">lees meer</a></p>
                        </div>
                    </div>
                @empty
                    <div class="activity">
                        <img src="{{ asset('/img/activityDisplayPicture/activity_placeholder.jpeg') }}"
                             class="activity-image">
                        <div class="activity-description empty-activity-description">
                            <p class="activity-description-header">Er zijn nog geen initiatieven geweest</p>
                            <p class="activity-description-content">Wil jij koffie schenken? Of heb jij een leuk idee?
                                <a href="{{ url('initiatief') }}"><b>Laat het ons weten!!</b></a>
                            </p>
                        </div>
                    </div>
                @endforelse
                <div class="pagination">
                    {{$finishedActivities->fragment("finished-activities-jump-section")->links()}}
                </div>
            </div>
        </div>
        <div class="vacancy-container" id="vacanciesWihtoutActivity-jump-section">
            <p class="content-header">Help mee!</p>
            <div class="vacancy-inner-container">
                @forelse ($vacanciesWihtoutActivity as $vacancy)
                    <a class="application-link" href="{{route('applications.create', $vacancy->id)}}">
                        <div class="vacancy">
                            <p class="vacancy-content">{{$vacancy->title}}</p>
                        </div>
                    </a>
                @empty
                    <p>Er zijn geen losstaande vacatures</p>
                @endforelse
                <div class="pagination" id="finished-activities-jump-section">
                    {{$vacanciesWihtoutActivity->fragment("vacanciesWihtoutActivity-jump-section")->links()}}
                </div>
            </div>
        </div>
    </div>
    <br><br><br>
@endsection
