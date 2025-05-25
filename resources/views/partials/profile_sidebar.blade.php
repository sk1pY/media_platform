@auth()
    <div class="sticky-top" style="top: 80px;">
        <div class="card border-0 rounded-3">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img
                        src="{{ Auth::user()->image ? Storage::url('avatarImages/' . Auth::user()->image) : asset('default_images/defaultAvatar.jpg') }}"
                        alt="..." class="object-fit-cover rounded" style="height: 40px; width: 40px;">
                    <h5 class="card-title mb-0 ms-3">{{ Auth::user()->name }}</h5>
                    @if(Auth()->user()->email_verified_at)
                        <span class="ms-2 badge text-bg-success w-auto">Email подтвержден</span>
                    @else
                        <div class="d-flex flex-column align-items-start ms-2 bg-warning  rounded-3 p-2">
                            <span class="badge  mb-1 text-dark">Email не подтвержден</span>
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit"
                                        class="btn btn-sm bg-transparent fw-bold text-decoration-underline p-0 m-0">
                                    Отправить письмо
                                </button>
                            </form>
                        </div>
                    @endif
                </div>


                <div class="m-0 p-0 d-flex flex-column gap-2 mt-3">
                    @can('admin_panel')
                        <a href="{{ route('admin.index') }}" class="btn btn-light border-danger bg-danger text-white">Админ
                            панель</a>
                    @endcan
                    <a href="{{ route('users.show',Auth::user())}}" class="btn btn-light">Мой публичный профиль</a>
                    <a href="{{ route('profile.posts')}}" class="btn btn-light">Управление постами</a>
                    <a href="{{ route('profile.edit',Auth::user())}}" class="btn btn-light">Настройки профиля</a>
                    <a href="{{ route('profile.comments.index') }}" class="btn btn-light">Комментарии</a>
                    <a href="{{ route('profile.bookmarks.index') }}" class="btn btn-light">Закладки</a>
                    <a href="{{ route('profile.subscriptions.index') }}" class="btn btn-light">Управление подписками</a>
                    <a href="{{ route('profile.hiddenPosts') }}" class="btn btn-light"> Скрытые посты </a>


                    <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light w-100">Выйти</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endauth
