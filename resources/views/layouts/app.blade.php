<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Main')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Roboto', 'Open Sans', Helvetica, Arial, sans-serif;


        }
        .nav-link:hover {
            background-color: white;
            color: black;
        }

        .red-heart {
            color: red;
        }


        .custom-dropdown {
            min-width: 200px;
            font-size: 1.1rem;
        }

        .custom-dropdown li {
            padding: 10px;
        }

        .custom-dropdown li:hover {
            background-color: #f8f9fa;
        }

        .custom-dropdown i {
            font-size: 1.2rem;
        }



    </style>
</head>

<body style="background-color: #F2F2F2">

<div class="container" style="margin-top: 80px;">
    <div class="row">
        <div class="col-3 ">
            @include('partials.nav')
            @include('partials.categories_sidebar')
        </div>
        <div class="col-6 p-0">
            @include('partials.alert.validation')
            @include('partials.alert.error')
            @include('partials.alert.success')
            @yield('content')
        </div>
        <div class="col-3">
            @include('partials.profile_sidebar')
        </div>
    </div>
</div>

</body>

</html>
