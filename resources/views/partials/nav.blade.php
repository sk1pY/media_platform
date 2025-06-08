<nav style="background-color: #0a53be; height: 60px;"
     class="navbar navbar-expand-lg navbar-light sticky-top p-0 m-0 rounded-2">
    <div class="container">
        <a href="{{ route('index') }}" class="navbar-brand me-auto fw-bold fs-4 text-white ms-3">Media</a>
            {{--        SEARCH --}}
            <div class="d-flex justify-content-center top-50 start-20  ">
                <div class="input-group rounded" style="width: 500px;">
                    <input id="search"
                           type="search" class="form-control rounded" placeholder="Поиск" aria-label="Search"
                           name="search" {{Request::is('profile*')?'disabled':''}}>
                </div>
            </div>
            {{--        SEARCH --}}

            <div class="d-flex justify-content-center align-items-center ms-auto">
                @guest
                    <a href="{{ route('register') }}" class="btn  me-3 bg-white p-2  rounded-3">Регистрация</a>
                    <a href="{{ route('login') }}" class="btn me-3 bg-primary p-2 rounded-3 text-white">Войти</a>
                @endguest
                @auth
                    <i class="bi bi-bell-fill text-white fs-4 me-4  "></i>
                    <button type="button" class="btn bg-white rounded-4 text-start p-2 w-100 w-auto me-3"
                            data-bs-toggle="modal" data-bs-target="#createPost" data-bs-dismiss="modal">
                        <i class="bi bi-plus-square me-1"></i>
                        <span class="text-black ">Опубликовать</span>

                    </button>
                @endauth
            </div>

    </div>
</nav>
{{-- MODAL WINDOW --}}
<div class="modal fade" id="createPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Новый пост</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.posts.store') }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Название</label>
                        <input name="title" type="text" class="form-control" id="exampleFormControlInput1"
                               placeholder="Заголовок" value="{{old('title')}}">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
                        <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                  rows="3">{{old('description')}}</textarea>
                    </div>
                    <div class="mb-3">
                        Выберите категорию
                        @if (count($categories) > 0)
                            <select name="category_id" class="form-select">
                                <option value="" selected>Без категории</option>
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

