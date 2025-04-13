<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Main')</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Roboto', 'Open Sans', Helvetica, Arial, sans-serif;

        }

        .color_grey {
            color: #595959;
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
            opacity: 0.7;
            /* Полупрозрачный белый налет */
        }

        .search-result {
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 0 0 5px 5px;
        }

        .sub_button_custom {
            --bs-btn-padding-y: .25rem;
            !important;
            --bs-btn-padding-x: .5rem;
            !important;
            --bs-btn-font-size: .75rem;
            !important;
        }
    </style>
</head>

<body style="background-color: #FAFAFC">

    <div class="container" style="margin-top: 80px;">
        <div class="row ">
            <div class="col-2 p-0 ">
                @include('menu_categories_nav', ['categories' => $categories])

            </div>
            <div class="col-7">
                @yield('content')

            </div>
            <div class="col-3 ">
                @include('right_sidebar.sidebar')
            </div>
        </div>
    </div>

</body>

</html>
