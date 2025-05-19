<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>
<div class="container" style="margin-top: 80px;">
    @include('partials.nav')

    <div class="row">
        <div class="col-3">
            @include('partials.profile_sidebar')
        </div>
        <div class="col">
            @include('partials.alert.auth')
            @include('partials.alert.validation')
            @include('partials.alert.error')
            @include('partials.alert.success')
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
