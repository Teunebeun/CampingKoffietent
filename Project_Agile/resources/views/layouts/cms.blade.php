<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/cms/CmsNavBar.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" defer></script>
    <script src="{{ asset('/js/cms/TableClickable.js') }}" defer></script>
    <link href='https://css.gg/css?=|home|calendar-dates|file-document|coffee|gift|briefcase|directory|profile|eye|info|readme|girl|mail|log-out|toggle-on|toggle-off|pen' rel='stylesheet'>
    @yield('css')
    @yield('js')
    <title>CMS - @yield('page-title')</title>
</head>
<body>
@include('/cms/CMSsidenav')
@include('/cms/CMSheader')
<div id="main">
    <div id="page-title">
        @yield('page-title')
    </div>
    @yield('succes-message')
    @yield('content')
</div>
</body>
</html>
