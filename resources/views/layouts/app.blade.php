<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Main')</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .red-heart {
            color: red; /* Красный цвет */
        }

        .custom-navbar {
            padding-left: 50px;
            padding-right: 50px;
        }
    </style>
</head>
<body style="background-color: #f2f2f2">


<nav style="background-color:#D9F0FF;" class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar">
    <div class="container-fluid">
        <a href="{{ route('index') }}" class="navbar-brand me-auto">POSTS</a>
        <a href="#" class="nav-item nav-link me-3">ADMIN</a>

        @guest
            <a href="{{ route('register') }}" class="nav-item nav-link me-3">Register</a>
            <a href="{{ route('login') }}" class="nav-item nav-link me-3">Login</a>
        @endguest
        @auth
            <button type="button" class="btn btn-outline-success me-3" data-bs-toggle="modal" data-bs-target="#Modal">
                Write Post
            </button>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle me-5" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                   {{ Auth::user() -> name }}
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('home') }}" class="text-decoration-none text-dark ms-3 ">Мой профиль</a>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-inline ms-3">
                            @csrf
                            <a href="#" class="text-decoration-none text-dark" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                        </form>


                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>


<div class="container content" style="margin-top: 50px;">
    @yield('content')
</div>
</body>
</html>
