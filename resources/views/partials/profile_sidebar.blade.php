<style>
    .nav-tabs .nav-link.active {
        background-color: #0a53be !important;
        color: white !important;
        border-color: #0a53be #0a53be #fff !important;
    }
</style>
@auth()
        <div class="card border-0 rounded-3">
            <div class="card-body p-0">
                <div class="d-flex align-items-center flex-column mt-3">
                    <img
                        src="{{ Auth::user()->image ? Storage::url('avatarImages/' . Auth::user()->image) : asset('default_images/defaultAvatar.jpg') }}"
                        alt="..." class="object-fit-cover rounded" style="height: 40px; width: 40px;">
                    <a href="{{ route('users.show', Auth()->user()) }}" class="card-title mb-0">
                        {{ Auth::user()->name }}
                    </a>


                    @if(optional(auth()->user())->email_verified_at)
                        <span class="ms-2 badge d-flex " style="background-color:#0a53be;">Email подтвержден</span>
                    @else
                        <div class="d-flex flex-column  bg-warning  rounded-3 p-1">
                            <span class="badge  mb-1 text-dark">Email не подтвержден</span>
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm bg-transparent fw-bold text-decoration-underline">
                                    Отправить письмо
                                </button>
                            </form>
                        </div>
                    @endif
                </div>


                <div class="rounded-3 p-3">
                    <ul class="nav flex-column nav-tabs ">
                        <li class="nav-item m-1">
                            @can('admin_panel')
                                <a href="{{ route('admin.index') }}" class="btn  rounded-pill text-dark nav-link " style="border-color:#0a53be;">Админ
                                    панель</a>
                            @endcan
                        </li>
                        <li class="nav-item m-1">
                            <a href="{{ route('users.show', Auth::user()) }}"
                               class="btn btn-light rounded-pill text-dark nav-link
           {{ request()->routeIs('users.show') && request()->route('user')->is(Auth::user()) ? 'active' : '' }}">
                                Мой публичный профиль
                            </a>
                        </li>

                        <li class="nav-item m-1 ">
                            <a href="{{ route('profile.posts.index')}}"
                               class="btn btn-light rounded-pill text-dark nav-link {{ request()->routeIs('profile.posts.index')  ? 'active' : '' }}">Управление
                                постами</a>

                        </li>
                        <li class="nav-item m-1">
                            <a href="{{ route('profile.edit')}}"
                               class="btn btn-light rounded-pill text-dark nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">Настройки
                                профиля</a>

                        </li>
                        <li class="nav-item m-1">
                            <a href="{{ route('profile.comments.index') }}"
                               class="btn btn-light rounded-pill text-dark nav-link {{ request()->routeIs('profile.comments.index')? 'active' : '' }}">Комментарии</a>

                        </li>
                        <li class="nav-item m-1">
                            <a href="{{ route('profile.bookmarks.index') }}"
                               class="btn btn-light rounded-pill text-dark nav-link {{ request()->routeIs('profile.bookmarks.index') ? 'active' : '' }}">Закладки</a>

                        </li>
                        <li class="nav-item m-1">
                            <a href="{{ route('profile.subscriptions.index') }}"
                               class="btn btn-light rounded-pill text-dark nav-link {{ request()->routeIs('profile.subscriptions.index')?'active' : '' }}">Управление
                                подписками</a>

                        </li>
                        <li class="nav-item m-1">
                            <a href="{{ route('profile.posts.hidden') }}"
                               class="btn btn-light rounded-pill text-dark nav-link {{ request()->routeIs('profile.posts.hidden')  ? 'active' : '' }}">
                                Скрытые посты </a>

                        </li>
                        <li class="nav-item m-1">
                            <a href="#" class="btn btn-light disabled rounded-pill text-dark nav-link "> Лента
                                активности пользователя</a>

                        </li>
                        <li class="nav-item m-1">
                            <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-light rounded-pill text-dark nav-link w-100">Выйти</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
@endauth
