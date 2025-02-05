@auth()
    <div class="sticky-top" style="top: 70px;">

        <div class="card border-0" style="width: 18rem;">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <img src="{{ Auth::user()->image ? Storage::url('avatarImages/' . $user->image) : asset('imageAvatar/def.jpg') }}"
                        alt="..." class="img-fluid" style="height: 40px; width: 40px; object-fit: cover;">
                    <h5 class="card-title mb-0 ms-2">{{ Auth::user()->name }}</h5>
                    <p class="card-text mb-0 ms-2 text-muted">Подписчиков {{ $countSubAuthors }}</p>
                </div>

                <div class="m-0 p-0 d-flex flex-column gap-2 mt-3">
                    <a href="{{ route('comments.index') }}" class="btn btn-light">Комментарии</a>
                    <a href="{{ route('bookmarks.index') }}" class="btn btn-light">Сохраненные</a>
                    <a href="{{ route('subscriptions.index') }}" class="btn btn-light">Управление подписками</a>
                    <a href="{{ route('hidden_posts') }}" class="btn btn-light"> Скрытые посты </a>
                    @role('admin')
                        <a href="{{ route('admin.index') }}" class="btn btn-light">Админ панель</a>
                    @endrole
                </div>


            </div>


        </div>
    </div>
@endauth
