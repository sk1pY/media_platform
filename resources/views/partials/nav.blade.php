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
                <div class="dropdown me-4">
                    <button class="btn dropdown-toggle position-relative" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                        <i class="bi bi-bell-fill text-white"></i>
                        @if(auth()->user()->unreadNotifications->count())
                            <span
                                class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
                        @endif
                    </button>

                    <ul class="dropdown-menu " style="width: 300px" aria-labelledby="notificationsDropdown"
                        style="width: auto; max-width: 100vw; max-height: 500px; overflow-y: auto;">
                        @foreach($notifications as $notification)
                            <li class="px-3 py-2 border-bottom {{ $notification->read_at ? 'bg-light' : 'bg-white' }}">
                                <div class="notification d-flex flex-wrap align-items-center">
                                    <span class="me-2">{{ $notification->data['user_name'] ?? '' }}</span>
                                    <span class="me-2">{{ $notification->data['message'] ?? '' }}</span>
                                    @if(isset($notification->data['post_id']))
                                        <a href="{{ route('posts.show', $notification->data['post_title']) }}">
                                            {{ $notification->data['post_title'] ?? 'Пост' }}
                                        </a>
                                    @endif
                                    <span class="ms-2"> {{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </li>
                        @endforeach
                            <li class="d-flex justify-content-center text-center py-2">
                                <a href="{{route('profile.notifications.index')}}">
                                    Посмотреть все уведомления
                                </a>

                            </li>

                            @php
                            auth()->user()->unreadNotifications->markAsRead();
                        @endphp
                    </ul>
                </div>



                </span>
                </button>
                <button type="button" class="btn bg-white rounded-4 text-start p-2 w-100 w-auto me-3"
                        data-bs-toggle="modal" data-bs-target="#createPost" data-bs-dismiss="modal">
                    <i class="bi bi-plus-square me-1"></i>
                    <span class="text-black ">Написать</span>
                </button>
                <a href="{{ route('users.show', Auth()->user()) }}" class="card-title mb-0">


                </a>
                <div class="dropdown">

                    <button class="btn btn-secondary dropdown-toggle bg-transparent border-0" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        <img
                            src="{{ Auth::user()->image ? Storage::url('avatarImages/' . Auth::user()->image) : asset('default_images/defaultAvatar.jpg') }}"
                            alt="..." class="object-fit-cover rounded-circle" style="height: 40px; width: 40px;">

                    </button>
                    <ul class="dropdown-menu text-center">
                        <li><a class="dropdown-item " href="{{route('profile.edit')}}">Мой профиль</a></li>
                        <li><a class="dropdown-item " href="{{route('profile.bookmarks.index')}}"> Закладки</a></li>
                        <form id="logout-form" action="{{ route('logout') }}" method="post" class="dropdown-item    ">
                            @csrf
                            <button type="submit" class="btn btn-light rounded-pill text-dark nav-link w-100">Выйти
                            </button>
                        </form>
                    </ul>
                </div>
            @endauth
        </div>

    </div>
</nav>
{{--SIDE--}}
@auth

    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
         id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">Уведомления</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">


        </div>
    </div>
@endauth

@include('partials.modal.create_post')

