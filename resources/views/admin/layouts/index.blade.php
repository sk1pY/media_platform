<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Admin</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        .row {
            margin: 0;
        }

        .col-2 {
            color: white;
        }

        .accordion-body a {
            font-size: 15px;
        }

    </style>

</head>
<body>
<div class="row min-vh-100">
    <div class="col-3 d-flex flex-column flex-shrink-0 p-3" style="background-color: #273A50;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="/admin" class="text-white text-decoration-none ms-2">
                <span class="fs-4">Admin Panel</span>
            </a>
            <a href="/" class="text-white text-decoration-none">
                выйти
            </a>
        </div>
        <hr class="bg-white">
        <ul class="according nav nav-pills flex-column mb-auto ">
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Управление пользователями
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse ms-4 show"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                                Пользователи</a>
                        </li>
                    </div>
                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.roles_and_permissions.index') }}" class="nav-link text-white">
                                Управление ролями и правами доступа
                            </a>
                        </li>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Модерация контента
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse ms-4 show"
                     data-bs-parent="#accordionExample">

                    <div class="accordion-body ">
                        <li>
                            <a href="{{ route('admin.posts.index') }}" class="nav-link text-white">
                                Просмотр списка публикаций
                            </a>

                        </li>
                    </div>
                    <div class="accordion-body ">
                        <li>
                            <a href="{{ route('admin.comments.index') }}" class="nav-link text-white">
                                Просмотр списка комментариев
                            </a>

                        </li>
                    </div>
                    <div class="accordion-body ">
                        <li>
                            <a href="{{ route('admin.claims.index') }}" class="nav-link text-white">
                                Просмотр списка жалоб
                            </a>

                        </li>
                    </div>
                    {{--                    <div class="accordion-body">--}}
                    {{--                        <li>--}}
                    {{--                            <a href="#" class="nav-link text-white">--}}
                    {{--                                Фильтры--}}
                    {{--                            </a>--}}

                    {{--                        </li>--}}
                    {{--                    </div>--}}
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Управление категориями
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse  ms-4 show"
                     data-bs-parent="#accordionExample">

                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                                Создание, редактирование и удаление категорий
                            </a>

                        </li>
                    </div>
                </div>
            </div>
            {{--            <div class="accordion-item">--}}
            {{--                <h2 class="accordion-header nav-link text-white d-flex">--}}
            {{--                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>--}}
            {{--                    <button class="accordion-button" type="button" data-bs-toggle="collapse"--}}
            {{--                            data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">--}}
            {{--                        Технические настройки--}}
            {{--                    </button>--}}
            {{--                </h2>--}}
            {{--                <div id="collapseFour" class="accordion-collapse collapse ms-4" data-bs-parent="#accordionExample">--}}

            {{--                    <div class="accordion-body">--}}
            {{--                        <li>--}}
            {{--                            <a href="#" class="nav-link text-white">--}}
            {{--                                Управление настройками сайта (логотип, описание, ключевые слова)--}}
            {{--                            </a>--}}

            {{--                        </li>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--            <div class="accordion-item">--}}
            {{--                <h2 class="accordion-header nav-link text-white d-flex">--}}
            {{--                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>--}}
            {{--                    <button class="accordion-button" type="button" data-bs-toggle="collapse"--}}
            {{--                            data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">--}}
            {{--                        Мониторинг активности                    </button>--}}
            {{--                </h2>--}}
            {{--                <div id="collapseFive" class="accordion-collapse collapse ms-4" data-bs-parent="#accordionExample">--}}

            {{--                    <div class="accordion-body">--}}
            {{--                        <li>--}}
            {{--                            <a href="#" class="nav-link text-white">--}}
            {{--                                Базовая статистика по просмотрам и жалобам                            </a>--}}

            {{--                        </li>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}


        </ul>
        <hr>


    </div>

    <div class="col-9">
        @include('partials.alert.validation')
        @include('partials.alert.error')
        @include('partials.alert.success')
        @yield('content')
    </div>
</div>


</body>
</html>
