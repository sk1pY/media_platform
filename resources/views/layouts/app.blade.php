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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.css"
          integrity="sha512-U9Y1sGB3sLIpZm3ePcrKbXVhXlnQNcuwGQJ2WjPjnp6XHqVTdgIlbaDzJXJIAuCTp3y22t+nhI4B88F/5ldjFA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        .nav-link:hover {
            background-color: white; /* Легкий серый фон при наведении */
            color: black; /* Темно-серый текст при наведении */
        }

        .red-heart {
            color: red;
        }

        .yellow-bookmark {
            color: #307df0;
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

        .blur-image:hover {
            opacity: 0.7; /* Полупрозрачный белый налет */
        }

        .search-result {
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 0 0 5px 5px;
        }

    </style>
</head>
<body style="background-color: #f2f2f2">
<nav style="background-color:#D9F0FF; height: 60px;"
     class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar">
    <div class="container-fluid " style="padding-left: 138px; padding-right: 120px;">
        <a href="{{ route('index') }}" class="navbar-brand me-auto fw-bold fs-4">PROJEKT</a>
        {{--        SEARCH--}}
        <div class="d-flex justify-content-center align-items-center me-auto search-container">
            <div class="input-group rounded" style="width: 600px; margin-left: 65px; position: relative;">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                       aria-describedby="search-addon" id="search" name="search">
                <ul class="list-group search-result"
                    style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000; display: none;"></ul>
            </div>
        </div>

        {{--        <a href="{{ route('admin')}}" class="nav-item nav-link me-3">ADMIN</a>--}}
        @guest
            <a href="{{ route('register') }}" class="nav-item nav-link me-3">Регистрация</a>
            <a href="{{ route('login') }}" class="nav-item nav-link me-3">Войти</a>
        @endguest
        @auth
            <i class="fa-regular fa-bell fa-lg" style="width: 40px; "></i>
            <button type="button" class="btn me-3 bg-white rounded-4 text-start p-2" data-bs-toggle="modal"
                    data-bs-target="#createPost" data-bs-dismiss="modal">
                <i class="fa-solid fa-pencil me-1   "></i>
                <span class="text-black " style="font-family: Arial, Helvetica, sans-serif;">Написать</span>
            </button>


            {{--DROPDOWN MENU PROFILE--}}
            <div class="dropdown">
                <div class="d-flex align-items-center link-secondary active drop" data-bs-toggle="dropdown"
                     data-bs-offset="140,160">
                    <img
                        src="{{Auth::user()->image ? Storage::url(Auth::user()->image):asset('imageAvatar/def.jpg') }}"                        class="blur-image dropdown-toggle me-2 rounded-circle"
                        style="width: 45px; height: 45px;"
                        alt="...">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end custom-dropdown mt-4" style="width: 200px; height: 200px">
                    <a href="{{ route('home',['id'=> Auth::user() -> id]) }}"
                       class="link-secondary text-decoration-none text-dark">

                        <li class="d-flex align-items-center">
                            <img
                                src="{{Auth::user()->image ? Storage::url(Auth::user()->image):asset('imageAvatar/def.jpg') }}"
                                class="dropdown-toggle me-2 rounded-circle"
                                style="width: 45px; height: 45px;"
                                alt="...">
                            <div class="d-flex flex-column">
                                {{ Auth::user()->name }}

                                <p class="mb-0">личный блог</p>
                            </div>
                        </li>
                    </a>
                    <a href="{{ route('bookmarks.index') }}" class="link-secondary text-decoration-none text-dark">
                        <li class="d-flex align-items-center">
                            <i class="fa-regular fa-bookmark me-2"></i>
                            Закладки
                        </li>
                    </a>

                    <li class="d-flex align-items-center" style="cursor: pointer"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>
                        <form id="logout-form" action="{{ route('logout') }}" method="post"
                              class="link-secondary d-inline">
                            @csrf
                            <span class="text-decoration-none text-dark">Выйти</span>
                        </form>
                    </li>


                </ul>
            </div>
            {{--END DROPDOWN MENU PROFILE--}}
        @endauth

    </div>
</nav>
{{-- MODAL WINDOW --}}
<div class="modal fade" id="createPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Add task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('create') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Title</label>
                        <input name="title" type="text" class="form-control" id="exampleFormControlInput1"
                               placeholder="title">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                  rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        Select a category
                        @if(count($categories) > 0)
                            <select name="cat_name" class="form-select">
                                <option selected></option>
                                @foreach($categories as $cat)
                                    <option>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput2" class="form-label">Image</label>
                        <input name="image" type="file" class="form-control" id="exampleFormControlInput2">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" value="send" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END MODAL WINDOW --}}
<div class="container" style="margin-top: 80px;">
    <div class="row">
        @if(View::hasSection('category'))
            <div class="col-lg-3">
                @yield('category')
            </div>
            <div class="col-lg-9" style="width: 600px">
                @yield('content')
            </div>
        @else
            <div class="col-lg-12">
                @yield('content')
            </div>
        @endif
    </div>
</div>
{{--SEARCH JS--}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            var value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route("live.search") }}',
                data: {'search': value},
                success: function (data) {
                    $('.search-result').html(data).show();
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).click(function (event) {
            let target = $(event.target);
            if (!target.closest('#search').length && !target.closest('.search-result').length) {
                $('.search-result').hide();
            }
        });

    });
</script>
</body>
</html>
