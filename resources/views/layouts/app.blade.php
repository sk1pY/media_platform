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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>

        .color_grey{
            color:#595959;
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

        .sub_button_custom{
            --bs-btn-padding-y: .25rem;!important;
            --bs-btn-padding-x: .5rem;!important;
            --bs-btn-font-size: .75rem;!important;
        }

    </style>
</head>
<body style="background-color: #f2f2f2">

<div class="container" style="margin-top: 80px;">
    <div class="row ">
        <div class="col-2 p-0 ">
            @include('menu_categories_nav',['categories'=>$categories])

        </div>
        <div class="col-7">
            @yield('content')
        </div>
            <div class="col-3 ">
                @include('sidebar')

            </div>
    </div>
</div>

</body>
</html>
