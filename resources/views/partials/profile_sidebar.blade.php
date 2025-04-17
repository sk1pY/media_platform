@auth()
    <div class="sticky-top" style="top: 80px;">

        <div class="card border-0" style="width: 18rem;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ Auth::user()->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                        alt="..." class="img-fluid" style="height: 40px; width: 40px; object-fit: cover;">
                    <h5 class="card-title mb-0 ms-2">{{ Auth::user()->name }}</h5>
                    <p class="card-text mb-0 ms-2 text-muted">Подписчиков {{ $countSubAuthors }}</p>
                </div>

                <div class="m-0 p-0 d-flex flex-column gap-2 mt-3">
                    <a href="{{ route('profile.index')}}" class="btn btn-light">Мой профиль</a>
                    <a href="{{ route('profile.comments.index') }}" class="btn btn-light">Комментарии</a>
                    <a href="{{ route('profile.bookmarks.index') }}" class="btn btn-light">Закладки</a>
                    <a href="{{ route('profile.subscriptions.index') }}" class="btn btn-light">Управление подписками</a>
                    <a href="{{ route('profile.hiddenPosts') }}" class="btn btn-light"> Скрытые посты </a>
                    @role('admin')
                        <a href="{{ route('admin.index') }}" class="btn btn-light">Админ панель</a>
                    @endrole

                    <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light w-100">Выйти</button>
                    </form>
                </div>
            </div>


        </div>
    </div>
@endauth
