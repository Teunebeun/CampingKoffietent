@extends ('layouts.main')

@section ('content')
    <link href="{{ asset('/css/initiative.css')}}" rel="stylesheet" type="text/css" media="all" />
    <main>
        <br />
        <div class="mainContainer mainContainerExtra">
            <div class="centerWrapper centerWrapperExtra">
                <h2 class="whiteColor">Uw donatie is binnen gekomen<br />Dank u wel!</h2>

            </div>
            <div class="submitWrapper">
                <a href="{{ route('home') }}">
                    <button type="button">Ga naar home</button>
                </a>
            </div>

        </div>
        <br />
        <br />

    </main>

@endsection
