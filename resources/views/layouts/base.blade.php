<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Main</title>
</head>
<style>
    body {
        font-family: 'Inter', sans-serif;
        font-weight: 400;
        font-size: 14px;
        margin: 0;
        padding: 0;
        overflow-y: scroll;
        background-color:#F2F2F2
    }

    a {
        color: black;
        text-decoration: none;
    }



</style>
<body>
@include('partials.alert.validation')

@include('partials.alert.auth')
@include('partials.alert.error')
@include('partials.alert.success')
@include('partials.alert.toast')
@if (Request::is('admin*'))
        @yield('content')
@else
    <div class="container" >
        @if (!Request::is('admin*'))
            @include('partials.nav')
        @endif
        <div>
            @yield('content')
        </div>

    </div>
@endif
</body>
</html>
