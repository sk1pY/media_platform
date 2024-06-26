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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.css"
          integrity="sha512-U9Y1sGB3sLIpZm3ePcrKbXVhXlnQNcuwGQJ2WjPjnp6XHqVTdgIlbaDzJXJIAuCTp3y22t+nhI4B88F/5ldjFA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .red-heart {
            color: red; /* Красный цвет */
        }

        .custom-dropdown {
            min-width: 200px; /* Увеличение ширины выпадающего меню */
            font-size: 1.1rem; /* Увеличение шрифта */
        }

        .custom-dropdown li {
            padding: 10px; /* Отступы между элементами */
        }

        .custom-dropdown li:hover {
            background-color: #f8f9fa; /* Эффект при наведении */
        }

        .custom-dropdown i {
            font-size: 1.2rem; /* Увеличение размера иконок */
        }


    </style>
</head>
<body style="background-color: #f2f2f2">


<nav style="background-color:#D9F0FF;" class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar">
    <div class="container-fluid " style="padding-left: 138px; padding-right: 120px;">
        <a href="{{ route('index') }}" class="navbar-brand me-auto fw-bold fs-4">PROJEKT</a>
        <div class="d-flex justify-content-center align-items-center me-auto">
            <div class="input-group rounded " style="width: 600px; margin-left: 130px">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon">
                <button class="btn border-0 rounded-end" type="button" id="search-addon"><i class="fas fa-search"></i></button>
            </div>
        </div>


        <a href="#" class="nav-item nav-link me-3">ADMIN</a>

        @guest

            <a href="{{ route('register') }}" class="nav-item nav-link me-3">Register</a>
            <a href="{{ route('login') }}" class="nav-item nav-link me-3">Login</a>
        @endguest
        @auth

            <button type="button" class="btn me-3 bg-white rounded-4 text-start p-2" data-bs-toggle="modal"
                    data-bs-target="#Modal">
                <i class="fa-solid fa-pencil me-2"></i>
                <span class="text-black fw-bold">Write Post</span>
            </button>
            {{--DROPDOWN MENU PROFILE--}}
            <div class="dropdown">
                <div class="d-flex align-items-center link-secondary active drop" data-bs-toggle="dropdown"
                     data-bs-offset="140,160">
                    <img
                        src="{{ Storage::url(Auth::user()->image) }}"
                        class="dropdown-toggle me-2 rounded-circle"
                        style="width: 45px; height: 45px;"
                        alt="...">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                    <li class="d-flex align-items-center">
                        <img
                            src="{{ Storage::url(Auth::user()->image) }}"
                            class="dropdown-toggle me-2 rounded-circle"
                            style="width: 45px; height: 45px;"
                            alt="...">
                        <div class="d-flex flex-column">
                            <a href="{{ route('home') }}" class="link-secondary text-decoration-none text-dark">
                                {{ Auth::user()->name }}
                            </a>
                            <p class="mb-0">личный блог</p>
                        </div>
                    </li>

                    <li class="d-flex align-items-center">
                        <i class="fa-regular fa-bookmark me-2"></i>
                        <a href="#" class="link-secondary text-decoration-none text-dark">
                            Закладки
                        </a>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                        <form id="logout-form" action="{{ route('logout') }}" method="post"
                              class="link-secondary d-inline">
                            @csrf
                            <a href="#" class="text-decoration-none text-dark"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выйти</a>
                        </form>
                    </li>
                </ul>
            </div>
            {{--END DROPDOWN MENU PROFILE--}}
        @endauth
    </div>
</nav>


<div class="container content" style="margin-top: 50px;">
    @yield('content')
</div>
</body>
</html>
