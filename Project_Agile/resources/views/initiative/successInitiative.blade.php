@extends ('layouts.main')

@section ('content')
	<link href="{{ asset('/css/initiative.css')}}" rel="stylesheet" type="text/css" media="all" />
	<main>
		<br />
		<div class="mainContainer mainContainerExtra">
			<div class="centerWrapper centerWrapperExtra">
				<h2 class="whiteColor">Uw idee is binnen gekomen en wordt naar gekeken!<br />Dank u wel voor uw bijdrage</h2>

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
