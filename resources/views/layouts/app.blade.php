<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Scripts -->
{{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
</head>
<body>
<div class="container">
        <nav class="nav navbar  navbar-light bg-light">
            <div class="container-fluid">
                <a href="{{ route('index') }}" class="navbar-brand me-auto">Main</a>
                @guest
                    <a href="{{ route('register') }}" class="nav-item nav-link ">Register</a>
                    <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
                @endguest
                @auth
                    <a href="{{ route('home') }}" class="nav-item nav-link">Home page</a>
                    <form action="{{ route('logout') }}" method="post" class="form-inline">
                        @csrf
                        <input type="submit" class="btn btn-danger" value="exit">
                    </form>
                @endauth
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
