<div class="d-flex flex-column flex-shrink-0 p-3" >
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
                    <i class="bi bi-plus-circle-dotted me-2"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Управление пользователями
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse ms-4 show"
                     data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                            Пользователи</a>

                    </div>
                    <div class="accordion-body">
                        <a href="{{ route('admin.roles_and_permissions.index') }}" class="nav-link text-white">
                            Управление ролями и правами доступа
                        </a>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2" ></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Модерация контента
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse ms-4 show"
                     data-bs-parent="#accordionExample">

                    <div class="accordion-body ">
                        <a href="{{ route('admin.posts.index') }}" class="nav-link text-white">
                            Просмотр списка публикаций
                        </a>
                    </div>
                    <div class="accordion-body ">
                        <a href="{{ route('admin.comments.index') }}" class="nav-link text-white">
                            Просмотр списка комментариев
                        </a>
                    </div>
                    <div class="accordion-body ">
                        <a href="{{ route('admin.claims.index') }}" class="nav-link text-white">
                            Просмотр списка жалоб
                        </a>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header nav-link text-white d-flex">
                    <i class="bi bi-plus-circle-dotted me-2"></i>
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        Управление категориями
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse  ms-4 show"
                     data-bs-parent="#accordionExample">

                    <div class="accordion-body">
                        <a href="{{ route('admin.categories.index') }}" class="nav-link text-white">
                            Создание, редактирование и удаление категорий
                        </a>
                    </div>
                </div>
            </div>
        </ul>
        <hr>
    </div>

