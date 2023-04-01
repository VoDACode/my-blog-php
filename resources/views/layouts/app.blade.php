<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

    @yield('head')

    <title>Blog</title>
</head>

<body>

    @include('partials.header')

    <div class="container">
        @yield('content')
    </div>

</body>
</html>