@extends ('layouts.main')

@section ('content')
	
    <link href="{{ asset('/css/initiative.css')}}" rel="stylesheet" type="text/css" media="all" />
	<main>
		<h2>Vertel ons je idee!</h2>
		<div class="mainContainer">
			<div class="centerWrapper">

				<form method="POST" id="usrform" action="{{URL('/initiatief/nieuw')}}">
					@csrf
			<!-- LEFT SIDE -->
				<div class="subContainer">
					<br />
					<span>Uw initiatief</span>

					<div class="questionBox">
						<span>Titel</span><br/>
						<input type="text" name="title" value="{{ old('title')}}" required placeholder="Hoe heet het initiatief?"/>
						@error('title')
							<span class="formError">{{ $errors->first('title') }}</span>
						@enderror
					</div>


					<div class="questionBox">
						<span>Beschrijving</span><br />
						<textarea name="description" form="usrform" required placeholder="Kan je wat meer vertellen?">{{ old('description')}}</textarea>
						@error('description')
							<span class="formError">{{ $errors->first('email') }}</span>
						@enderror
					</div>
					</div>
					<div class="subContainer subContainerlast">
						<br />
						<span>Wie bent u?</span>
						<div class="questionBox">
							<span>Voornaam</span><br/>
							<input type="text" name="name" value="{{ old('name')}}" required placeholder="Wat is je naam?"/>
							@error('name')
								<span class="formError">{{ $errors->first('name') }}</span>
							@enderror
						</div>
						<div class="questionBox">
							<span>Tussenvoegsel(s)</span><br/>
							<input type="text" name="middlename" value="{{ old('middlename')}}" placeholder="Tussenvoegsel"/>
							@error('middlename')
								<span class="formError">{{ $errors->first('middlename') }}</span>
							@enderror
						</div>
						<div class="questionBox">
							<span>Achternaam</span><br/>
							<input type="text" name="lastname" value="{{ old('lastname')}}" required placeholder="Wat is je achternaam?"/>
							@error('lastname')
								<span class="formError">{{ $errors->first('lastname') }}</span>
							@enderror
						</div>
						<div class="questionBox">
							<span>Telefoonnummer</span><br/>
							<input type="text" name="phonenumber" value="{{ old('phonenumber')}}" required placeholder="Telefoonnummer"/>
							@error('phonenumber')
								<span class="formError">{{ $errors->first('phonenumber') }}</span>
							@enderror
						</div>
						<div class="questionBox">
							<span>E-mail</span><br/>
							<input type="text" name="email" value="{{ old('email')}}" required placeholder="E-mail"/>
							@error('email')
								<span class="formError">{{ $errors->first('email') }}</span>
							@enderror
						</div>
					</div>
					<br />
					<br />
					<br />
					<br />
					<div class="submitWrapper">
						<input type="submit" value="Verstuur uw idee"/>
					</div>
				</form>

			</div>
		</div>

	</main>
	<br />
	<br />

@endsection
