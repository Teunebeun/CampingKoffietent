@extends ('layouts.main')

@section('css')
<link rel="stylesheet" href="{{ asset('/css/help-out.css') }}">
@endsection

@section('content')
<h1 class="big-header" id="vacancy-paginate-jump-section">Help mee met een initiatief!</h1>
<hr>
<form method="GET" action="/help-mee/zoek">
    @csrf
    <div class="search-container">

        <div class="search-input">
            <p class="search-header">Zoek op trefwoord</p>

            <label>
                <input type="text" name="searchText" class="search-bar" placeholder="&#xF002; Zoek"
                    value="{{request('searchText')}}">
                <button type="submit" name="action" value="searchByText" id="search"> ></button>
            </label>
        </div>
        <div class="search-input">
            <p class="search-header">Zoek op datum</p>

            <label>
                <input type="date" name="searchDate" class="search-bar" value="{{request('searchDate')}}">
                <button type="submit" name="action" value="searchByDate"> ></button>
            </label>
        </div>

    </div>
</form>

<div class="vacancy-paginate-container">
    <div class="vacancy-container">
        @forelse ($vacancies as $vacancy)

        <div class="vacancy">
            @if($vacancy->picture != null)
            <img src="{{ asset($vacancy->picture) }}" class="vacancy-image">
            @else
            <img src="{{ URL::asset('img/Activity-placeholder.png') }}" class="vacancy-image">
            @endif
            <p class="vacancy-header">{{$vacancy->title}}</p>
            <p class="vacancy-date">{{ $vacancy->start_datetime->format('d-m-Y') }}</p>
            <p class="vacancy-time">{{ $vacancy->start_datetime->format('H:i') }}
                - {{ $vacancy->end_datetime->format('H:i') }}</p>
            @if (count($vacancy->activity->campingbazen) > 0)
            <p class="vacancy-campingbaas-title">Campingbaas:</p>
            @else
            <p class="vacancy-campingbaas-title"> <br></p>
            @endif
            <p class="vacancy-campingbaas-content">
                @forelse ($vacancy->activity->campingbazen as $campingbaas)
                @if($loop->last)
                {{$campingbaas->firstname}}
                @else
                {{$campingbaas->firstname}},
                @endif
                @empty
                @endforelse
            </p>
            <p class="vacancy-content">{{ $vacancy->description }}</p>
            <a href="{{route('applications.create', $vacancy->id)}}" class="application-link">
                <div class="vacancy-button">
                    <p class="vacancy-button-content">Help mee!</p>
                </div>
            </a>
        </div>
        @empty
        <div class="vacancy">
            <img src="{{ asset('/img/activityDisplayPicture/activity_placeholder.jpeg') }}" class="vacancy-image">
            <p class="vacancy-header">Begin een initiatief!</p>
            <p class="vacancy-content">Er zijn momenteel geen openstaande vacatures. Je kunt altijd even langskomen, ook
                is het mogelijk om zelf een initiatief te verzinnen!</p>
            <a href="{{ url('initiatief/nieuw') }}" class="application-link">
                <div class="vacancy-button">
                    <p class="vacancy-button-content">Begin een initiatief!</p>
                </div>
            </a>
        </div>
        @endforelse
    </div>
    <div class="pagination" id="finished-activities-jump-section">
        {{$vacancies->fragment("vacancy-paginate-jump-section")->appends(request()->input())->links()}}
    </div>
    <br>
</div>

<h1 class="big-header" id="vacancy-images-paginate-jump-section">Doe mee!</h1>
<hr>
<div>
    <div class="vacancy-image-container">
        @forelse ($vacanciesWithoutActivity as $vacancy)
        <a class="vacancy-image-image" href="{{route('applications.create', $vacancy->id)}}">
            <div class="vacancy-image-image__overlay">{{$vacancy->title}}</div>
            @if($vacancy->picture != null)
            <img src="{{ asset($vacancy->picture) }}">
            @else
            <img src="{{ URL::asset('img/Activity-placeholder.png') }}">
            @endif
        </a>
        @empty
            <p class="vacancy-image-empty">Er zijn momenteel geen openstaande vacatures. Je kunt altijd even langskomen! <br><br><a href="{{ url('openingstijden') }}">Zie openingstijden</a></p>
        @endforelse
    </div>
    <div class="pagination" id="finished-activities-jump-section">
        {{$vacanciesWithoutActivity->fragment("vacancy-images-paginate-jump-section")->appends(request()->input())->links()}}
    </div>
</div>


@endsection