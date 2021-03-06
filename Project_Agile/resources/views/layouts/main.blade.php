<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camping Koffietent</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/NavBar.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    @yield('css')
</head>

<body>
    @include('header')
    @yield('content')
    @include('footer')
</body>

</html>
