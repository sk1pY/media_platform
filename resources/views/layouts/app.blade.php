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
<body>
<div class="container ">
    <nav class="nav navbar  navbar-light bg-light">
        <div class="container-fluid">
            <a href="{{ route('index') }}" class="navbar-brand me-auto">Main</a>
            @guest
                <a href="{{ route('register') }}" class="nav-item nav-link ">Register</a>
                <a href="{{ route('login') }}" class="nav-item nav-link">Login</a>
            @endguest
            @auth
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal">
                    Add task
                </button>
                <!-- Modal -->
                <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add task</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('create') }}" enctype="multipart/form-data" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Title</label>
                                        <input name='title' type="text" class="form-control"
                                               id="exampleFormControlInput1" placeholder="title">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                        <textarea name='description' class="form-control"
                                                  id="exampleFormControlTextarea1" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput2" class="form-label">image</label>
                                        <input name='image' type="file" class="form-control"
                                               id="exampleFormControlInput2">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                    <input type="submit" value="send">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
