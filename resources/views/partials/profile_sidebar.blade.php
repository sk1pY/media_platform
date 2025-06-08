@auth()
    <div >
        <div class="card border-0 rounded-3">
            <div class="card-body p-0">
                <div class="d-flex align-items-center flex-column" >
                    <img src="{{ Auth::user()->image ? Storage::url('avatarImages/' . Auth::user()->image) : asset('default_images/defaultAvatar.jpg') }}"
                        alt="..." class="object-fit-cover rounded" style="height: 40px; width: 40px;">
                    <a href="{{ route('users.show', Auth()->user()) }}" class="card-title mb-0">
                        {{ Auth::user()->name }}
                    </a>


                @if(optional(auth()->user())->email_verified_at)
                        <span class="ms-2 badge text-bg-success d-flex ">Email подтвержден</span>
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


                <div class="d-flex flex-column gap-2 mt-3">
                    @can('admin_panel')
                        <a href="{{ route('admin.index') }}" class="btn   text-white" style="background-color: #0a53be">Админ
                            панель</a>
                    @endcan
                    <a href="{{ route('users.show',Auth()->user())}}" class="btn btn-light">Мой публичный профиль</a>
                    <a href="{{ route('profile.posts.index')}}" class="btn btn-light">Управление постами</a>
                    <a href="{{ route('profile.edit')}}" class="btn btn-light">Настройки профиля</a>
                    <a href="{{ route('profile.comments.index') }}" class="btn btn-light">Комментарии</a>
                    <a href="{{ route('profile.bookmarks.index') }}" class="btn btn-light">Закладки</a>
                    <a href="{{ route('profile.subscriptions.index') }}" class="btn btn-light">Управление подписками</a>
                    <a href="{{ route('profile.posts.hidden') }}" class="btn btn-light"> Скрытые посты </a>
                    <a href="#" class="btn btn-light disabled"> Лента активности пользователя</a>


                    <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light w-100">Выйти</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endauth
