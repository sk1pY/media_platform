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
            <!-- {{--                <i class="fa-regular fa-bell fa-lg" style="width: 40px; "></i> --}} -->
            <button type="button" class="btn me-3 bg-white rounded-4 text-start p-2 w-100 w-auto" data-bs-toggle="modal"
                    data-bs-target="#createPost" data-bs-dismiss="modal">

                <i class="bi bi-pencil-square me-1"></i>
                <span class="text-black">Создать</span>

            </button>
            {{-- DROPDOWN MENU PROFILE --}}
            <div class="dropdown">
                <div class="d-flex align-items-center link-secondary active drop" data-bs-toggle="dropdown"
                     data-bs-offset="140,160">
                    <img
                        src="{{ Auth::user()->image ? Storage::url('avatarImages/' . Auth::user()->image) : asset('imageAvatar/def.jpg') }}"
                        class="blur-image dropdown-toggle me-2 rounded-circle" style="width: 45px; height: 45px;"
                        alt="...">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end custom-dropdown mt-4 h-auto w-auto">
                    <a href="{{ route('home.profile.show', ['user' => Auth::user()->id]) }}"
                       class="link-secondary text-decoration-none text-dark">
                        <li class="d-flex align-items-center">
                            <img
                                src="{{ Auth::user()->image ? Storage::url('avatarImages/' . Auth::user()->image) : asset('imageAvatar/def.jpg') }}"
                                class="dropdown-toggle me-2 rounded-circle" style="width: 45px; height: 45px;"
                                alt="...">
                            <div class="d-flex flex-column">
                                {{ Auth::user()->name }}

                                <p class="mb-0">личный блог</p>
                            </div>
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
            {{-- END DROPDOWN MENU PROFILE --}}
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
                            <select name="cat_name" class="form-select">
                                <option selected></option>
                                @foreach ($categories as $cat)
                                    <option>{{ $cat->name }}</option>
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
{{-- CATEGORIES --}}
<div class="" style="top: 70px;">
    {{--    <div class="position-sticky" style="top: 75px;  background-color: #f2f2f2;"> --}}
    <ul class="nav flex-column">
        <a style="font-size: 1.1rem;" class=" rounded-pill  nav-link active  text-dark" aria-current="page"
           href="{{ route('popular') }}">
            <i class="fa-solid fa-fire p-0" style="width: 20px; height: 20px"></i>
            <span class="ms-1">Популярное</span>
        </a>
        <a style="font-size: 1.1rem;" class="rounded-pill nav-link active text-dark" aria-current="page"
           href="{{ route('newest') }}">
            <i class="fa-regular fa-clock" style="width: 20px; height: 20px"></i>
            <span class="ms-1">Свежее за 24ч</span>
        </a>
        <a style="font-size: 1.1rem;" class="rounded-pill nav-link active text-dark" aria-current="page"
           href="{{ route('my_feed') }}">
            <i class="fa-regular fa-clipboard" style="width: 20px; height: 20px"></i>
            <span class="ms-1">Моя лента</span>
        </a>
        <h1 class="fs-6 mt-3 ms-3" style="color: grey;">Темы</h1>

        @if (count($categories) > 0)
            @foreach ($categories as $cat)
                <li class="rounded-pill nav-link d-flex align-items-center ">
                    <img src="{{ Storage::url('categoryImages/' . $cat->image) }}" alt="..."
                         class=" rounded-circle" style="width:30px;height: 30px">

                    <a style="font-size: 1.1rem;"
                       class="ms-2 link-secondary active text fw-normal text-dark text-decoration-none"
                       href="{{ route('categories.show', ['category' => $cat->id]) }}">{{ $cat->name }}</a>
                </li>
            @endforeach
    </ul>
    @endif
</div>
{{-- END CATEGORIES --}}
{{-- SEARCH JS --}}
<script type="text/javascript">
    $(document).ready(function () {
        $('#search').on('keyup', function () {
            var value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ route('live.search') }}',
                data: {
                    'search': value
                },
                success: function (data) {
                    $('.search-result').html(data).show();
                }
            });
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

        });
        $(document).click(function (event) {
            let target = $(event.target);
            if (!target.closest('#search').length && !target.closest('.search-result').length) {
                $('.search-result').hide();
            }
        });

    });
</script>
