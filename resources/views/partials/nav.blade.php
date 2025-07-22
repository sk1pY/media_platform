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

                <button type="button" class="btn btn-primary position-relative m-4">
                    <i class="bi bi-bell-fill text-white " data-bs-toggle="offcanvas"
                       data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling">
                    </i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ auth()->user()->unreadNotifications->count() }}
    <span class="visually-hidden">unread messages</span>
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

                        <button class="btn btn-secondary dropdown-toggle bg-transparent border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
            @php
                $notifications = auth()->user()->unreadNotifications;
                auth()->user()->unreadNotifications->markAsRead();
            @endphp

            <ul class="list-group list-group-flush">
                @foreach (auth()->user()->notifications as $notification)

                    <li class="list-group-item">
                        <img
                            src="{{ Auth::user()->image ? Storage::url('avatarImages/' . $notification->data['follower_image']) : asset('default_images/defaultAvatar.jpg') }}"
                            alt="..." class="object-fit-cover rounded" style="height: 40px; width: 40px;">
                        <a href="{{ route('users.show', ['user' => $notification->data['follower_name']]) }}">
                            {{ $notification->data['follower_name'] }}
                        </a> подписался на вас.
                        <span>{{$notification->created_at->diffForHumans()}}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endauth

@include('partials.modal.create_post')

