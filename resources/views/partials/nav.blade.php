    <nav style="background-color:#D9F0FF; height: 60px;"
     class="navbar navbar-expand-lg navbar-light fixed-top custom-navbar">
    <div class="container-fluid " style="padding-left: 120px; padding-right: 120px;">
        <div class="d-flex">
            <a href="{{ route('index') }}" class="navbar-brand me-auto fw-bold fs-4">PROJEKT</a>
        </div>

        {{--        SEARCH --}}
        <div class="d-flex justify-content-center align-items-center me-auto search-container">
            <div class="input-group rounded" style="width: 500px; margin-left: 165px; position: relative;">
                <input type="search" class="form-control rounded" placeholder="Поиск" aria-label="Search"
                       aria-describedby="search-addon" id="search" name="search">
                <ul class="list-group search-result"
                    style="position: absolute; top: 100%; left: 0; width: 100%; z-index: 1000; display: none;"></ul>
            </div>
        </div>

        @guest
            <a href="{{ route('register') }}" class="btn  me-3 bg-white p-2  rounded-5">Регистрация</a>
            <a href="{{ route('login') }}" class="btn me-3 bg-white p-2 rounded-5">Войти</a>
        @endguest
        @auth
            <button type="button" class="btn me-3 bg-white rounded-4 text-start p-2 w-100 w-auto" data-bs-toggle="modal"
                    data-bs-target="#createPost" data-bs-dismiss="modal">

                <i class="bi bi-plus-square me-1"></i>
                <span class="text-black">Опубликовать пост</span>

            </button>
        @endauth
    </div>
</nav>
{{-- MODAL WINDOW --}}
<div class="modal fade" id="createPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Написать новый пост</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posts.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Title</label>
                        <input name="title" type="text" class="form-control" id="exampleFormControlInput1"
                               placeholder="Заголовок">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                  rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        Выберите категорию
                        @if (count($categories) > 0)
                            <select name="category_id" class="form-select">
                                <option selected></option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput2" class="form-label">Фото поста</label>
                        <input name="image" type="file" class="form-control" id="exampleFormControlInput2">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <input type="submit" value="Создать" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END MODAL WINDOW --}}

