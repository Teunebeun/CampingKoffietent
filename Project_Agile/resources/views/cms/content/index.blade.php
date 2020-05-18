@extends('layouts.cms')

@section('css')
<link href="{{ asset('css/CMS/content.css') }}" rel="stylesheet">
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
<script src="{{ asset('/js/cms/TableClickable.js') }}" defer></script>
@endsection

@section('succes-message')
<div class="success-container">
    @if(session()->get('success'))
        <div>
            <p class="success-content">{{ session()->get('success') }}</p>
        </div>
    @endif
</div>  
@endsection

@section('page-title')
Content
@endsection

@section('content')
<div class="index-container">
    <a href="{{ route('cms-content-homepage.edit') }}" class="link">
        <p>Hoofdpagina</p><br>
    </a>
    <a href="{{ route('cms-content-initiative.edit') }}" class="link">
        <p>Initiatieven</p><br>
    </a>
    <a href="{{ route('cms-content-contact.edit') }}" class="link">
        <p>Contact opnemen</p><br>
    </a>
    <a href="{{ route('cms-content-openingHours.edit') }}" class="link">
        <p>Openingstijden</p><br>
    </a>
    <a href="{{ route('cms-content-other.edit') }}" class="link">
        <p>Overig</p>
    </a>
</div>
@endsection