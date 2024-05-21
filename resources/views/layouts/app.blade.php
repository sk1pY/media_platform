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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <!-- Scripts -->
    {{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
</head>
<body style='background-color:#f2f2f2' class="bg-light">
<div class="container ">
    <nav  style="background-color:#D9F0FF" class="nav navbar text-primary-emphasis ">
        <div class="container-fluid">

            <a href="{{ route('index') }}" class="navbar-brand me-auto">POSTS</a>
            <a href="{{ route('admin.index') }}" class="nav-item nav-link">ADMIN</a>

        @guest
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <a href="{{ route('register') }}" class="nav-item nav-link ">Register</a>
                <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
            @endguest
            @auth

                <!-- Modal  END-->
                <a href="{{ route('home') }}" class="nav-item nav-link">Home page</a>
                <form action="{{ route('logout') }}" method="post" class="form-inline">
                    @csrf
                    <input type="submit" class="btn btn-danger" value="exit">
                </form>
            @endauth
        </div>
    </nav>
    @yield('content')
    </div>
</body>
</html>
