<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <!-- Подключение jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Подключение DataTables CSS и JS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <!-- Подключение jQuery UI для sortable -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <title>Admin</title>
    <style>
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

<div class="row">
    <div class="col-3 d-flex flex-column flex-shrink-0 p-3 " style="background-color: #273A50;height: 100vh;">
        <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32"></svg>
            <span class="fs-4">Admin Panel</span>
        </a>
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
                <div id="collapseOne" class="accordion-collapse collapse ms-4" data-bs-parent="#accordionExample">
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
{{--                    <div class="accordion-body">--}}
{{--                        <li>--}}
{{--                            <a href="#" class="nav-link text-white">--}}
{{--                                Редактирование профилей пользователей--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </div>--}}
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
                <div id="collapseTwo" class="accordion-collapse collapse ms-4" data-bs-parent="#accordionExample">

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
                                Просмотр списка  комментариев
                            </a>

                        </li>
                    </div>
                    <div class="accordion-body">
                        <li>
                            <a href="#" class="nav-link text-white">
                                Фильтры
                            </a>

                        </li>
                    </div>
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
                <div id="collapseThree" class="accordion-collapse collapse  ms-4" data-bs-parent="#accordionExample">

                    <div class="accordion-body">
                        <li>
                            <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                                Создание, редактирование и удаление категорий
                            </a>

                        </li>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                        Технические настройки
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse ms-4" data-bs-parent="#accordionExample">

                    <div class="accordion-body">
                        <li>
                            <a href="#" class="nav-link text-white">
                                Управление настройками сайта (логотип, описание, ключевые слова)
                            </a>

                        </li>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" width="16" height="16"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                        Мониторинг активности                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse ms-4" data-bs-parent="#accordionExample">

                    <div class="accordion-body">
                        <li>
                            <a href="#" class="nav-link text-white">
                                Базовая статистика по просмотрам и жалобам                            </a>

                        </li>
                    </div>
                </div>
            </div>


        </ul>
        <hr>


    </div>

    <div class="col-8">
        @yield('content')
    </div>
</div>

</body>
</html>
