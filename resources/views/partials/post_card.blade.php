{{-- MAIN CARDS CONTENT --}}
<div class="card border-0 mb-4">
    <div class="card-body">
        <div class="row align-items-center ">
            <div class="col-auto ">
                <img
                    src="{{ $post->user->image ? Storage::url('avatarImages/' . $post->user->image) : asset('default_images/defaultAvatar.jpg') }}"
                    class="rounded-circle" style="width: 45px; height: 45px;"
                    alt="{{ Storage::url('avatarImages/' . $post->user->image) }}">
            </div>
            <div class="col p-0">
                <div><a class="fw-bold link-dark text-decoration-none "
                        href="{{ route('users.show', $post->user) }}">
                        {{ $post->user->name }}
                    </a>
                </div>
                <div>
                    @if ($post->category)
                        <a class="link-secondary active fs-7 text-dark text-decoration-none me-2"
                           href="{{ route('categories.show', $post->category) }}">
                            {{ $post->category->name }}
                        </a>
                    @endif
                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>

                </div>

            </div>
            {{--                3 POINTS --}}
            @auth
                <div class="col-auto d-flex">
                    @if ($post->user->id != auth()->id())
                        <div class="d-flex sub-button me-3" style="height: 35px; cursor: pointer;"
                             data-author-id="{{ $post->user->id }}">
                            <button class=" btn btn-secondary  ms-3  "></button>
                        </div>
                    @endif
                    <div class="dropdown" style="position: relative; z-index: 1050;">
                        <a style="cursor: pointer; color: #595959;" class="custom-dropdown text-decoration-none "
                           data-bs-toggle="dropdown"><i class="bi bi-three-dots text-center"
                                                        style="font-size: 27px;"></i></a>

                        <ul class="dropdown-menu">
                            <li>
                                <form action="{{ route('posts.hide',$post) }}" method="post">
                                    @csrf
                                    <input class="dropdown-item" type="submit" name="hidden" value="Скрыть">
                                </form>
                            <li><a data-bs-toggle="modal" data-bs-target="#complain_post" class="dropdown-item"
                                   href="#">Пожаловаться</a></li>
                            @if($profileFlag ?? null)
                                <li><a data-bs-toggle="modal" data-bs-target="#update_post{{$post->id}}"
                                       class="dropdown-item"
                                       href="#">Изменить</a></li>
                                <li>
                                    <form action="{{ route('posts.destroy',$post) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input class="dropdown-item" type="submit" value="Удалить">
                                    </form>
                                </li>
                            @endif
                            @if($bookmarkFlag ?? null)
                                <li>
                                    <form action="{{ route('profile.bookmarks.destroy',$bookmark) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input class="dropdown-item"  type="submit" value="Удалить закладку">
                                    </form>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
                {{--          END  3 POINTS--}}

                {{-- MODAL CLAIM WINDOW --}}
                <div class="modal fade" id="complain_post" tabindex="-1" aria-labelledby="complainModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="complainModalLabel">Пожаловаться на пост</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Закрыть"></button>
                            </div>
                            <form action="{{ route('admin.claims.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <p>Выберите причину жалобы:</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name" id="reason1"
                                                   value="Оскорбления и грубое общение">
                                            <label class="form-check-label" for="reason1">Оскорбления и грубое
                                                общение</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name" id="reason2"
                                                   value="Преследование и травля">
                                            <label class="form-check-label" for="reason2">Преследование и травля</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name" id="reason3"
                                                   value="Призывы и одобрение насилия">
                                            <label class="form-check-label" for="reason3">Призывы и одобрение
                                                насилия</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name" id="reason4"
                                                   value="Запрещенный к публикации контент">
                                            <label class="form-check-label" for="reason4">Запрещенный к публикации
                                                контент</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name" id="reason5"
                                                   value="Реклама и ссылки">
                                            <label class="form-check-label" for="reason5">Реклама и ссылки</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="name" id="reason6"
                                                   value="Другое">
                                            <label class="form-check-label" for="reason6">Другое</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть
                                    </button>
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- END MODAL WINDOW --}}

            @endauth
        </div>
        <div class="mt-3 mb-2">
            <a href="{{ route('posts.show',$post) }}" class="text-decoration-none text-dark hover-effect fs-4 ">
                {{ $post->title }}
            </a>
        </div>

        <p class="card-text">{{ substr($post->description, 0, 250) }}...</p>
        <div class="card-img-container">
            <img
                src="{{ $post->image?Storage::url('postImages/'.$post->image):asset('default_images/defaultImage.png') }}"
                style="width: 100%; height: 290px"
                alt="image_not_found"
                class="card-img-top rounded-3">
        </div>
        {{--       LIKE --}}
        <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
            <div  class="post d-flex align-items-center">
                <div style="cursor: pointer" class="like-button me-3"
                     data-post-id="{{ $post->id }}"
                     data-url = "{{route('posts.like')}}">
                    <i class="bi like_button text-danger
                        {{ in_array($post->id, $likedPostUser) ? 'bi-heart-fill' : 'bi-heart' }}">
                        <span class="like-count">{{ $post->likes }}</span>
                    </i>
                </div>
                {{--                    LIKE --}}
                {{--                            COMMENTS --}}
                <a href="{{ route('posts.show', ['post' => $post->id]) }}#comment_section" style="cursor: pointer"
                   class="text-decoration-none">
                    <i class="bi bi-chat-left-text  color_grey">
                        <span>{{ $post->comments_count }}</span>
                    </i>
                </a>
                {{-- BOOKMARKS --}}
                <div style="cursor: pointer" class="bookmark-button "
                     data-bookmark-id="{{ $post->id }}"
                     data-url="{{route('profile.bookmarks.store')}}">
                    <i class="bookmark_button ms-3 bi {{ in_array($post->id, $bookmarkPostUser) ? 'bi-bookmark-fill color_grey' : 'bi-bookmark' }}"></i>
                </div>
                <a class="b ms-3" href="#" onclick="copyPostLink('{{ route('posts.show', $post->id) }}')">
                    <i class="bi bi-share "></i>
                </a>

            </div>
            {{--                            VIEWS --}}
            <i style="user-select: none; font-size: 1.2rem" class=" bi bi-eye-fill me-2">
                <span id="view-number">{{ $post->views }}</span>
            </i>
        </div>

    </div>
</div>

<script>
    function copyPostLink(url) {
        const tempInput = document.createElement('input');
        tempInput.value = url;
        document.body.appendChild(tempInput);

        tempInput.select();
        tempInput.setSelectionRange(0, 99999);

        document.execCommand('copy');

        document.body.removeChild(tempInput);

        alert('Ссылка скопирована: ' + url);
    }
</script>
{{-- END MAIN CARDS CONTENT --}}
