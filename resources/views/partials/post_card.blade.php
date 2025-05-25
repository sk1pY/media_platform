<div id="card-{{$post->id}}" class="card border-0 mb-3 rounded-3">
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


            @auth
                <div class="col-auto d-flex">

                    {{--                SUBSCRIBE BUTTON--}}
                    @can('subscribe_users')
                        @if ($post->user->id != auth()->id())
                            <div class="d-flex sub-button me-3" style="height: 35px; cursor: pointer;"
                                 data-author-id="{{ $post->user->id }}"
                                 data-url="{{route('subscribe')}}" +>
                                <button
                                    class=" btn  ms-3 {{in_array($post->user->id,$subAuthors)?'btn-outline-secondary':'btn-secondary '}}">
                                    {{in_array($post->user->id,$subAuthors)?'Отписаться':'Подписаться'}}</button>
                            </div>
                        @endif
                    @endcan
                    {{--                SUBSCRIBE BUTTON END--}}

                    {{--                3 POINTS BUTTON--}}

                    <div class="dropdown">
                        <a style="cursor: pointer; color: #595959;" class="custom-dropdown text-decoration-none "
                           data-bs-toggle="dropdown"><i class="bi bi-three-dots text-center"
                                                        style="font-size: 27px;"></i></a>
                        <ul class="dropdown-menu" style=" z-index: 1050;">
                            @can('hidden_posts')

                                <li>
                                    <form action="{{ route('posts.hide',$post) }}" method="post">
                                        @csrf
                                        <input class="dropdown-item" type="submit" name="hidden"
                                               value="Скрыть">
                                    </form>
                                </li>

                            @endcan
                            @can('complain_posts')

                                <li>
                                    <a data-bs-toggle="modal" data-bs-target="#complain_post" class="dropdown-item"
                                       href="#">Пожаловаться</a>
                                </li>
                            @endcan
                            @can('update',$post)
                                <li><a data-bs-toggle="modal" data-bs-target="#update_post{{$post->id}}"
                                       class="dropdown-item"
                                       href="#">Изменить</a></li>
                                <li>
                                    <form action="{{ route('posts.destroy',$post) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <input class="dropdown-item" type="submit" value="Удалить"
                                               onclick="return confirm('Вы действительно хотите удалить этот пост?')">
                                    </form>
                                </li>
                            @endcan
                        </ul>

                    </div>
                </div>
                {{--          END  3 POINTS BUTTON--}}

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

        <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
            <div class="d-flex align-items-center">
                {{--       LIKE --}}
                <div id="like-button" class=" like-button me-3" style="cursor:pointer"
                     data-post-id="{{ $post->id }}"
                     data-url="{{ route('posts.like') }}">
                    <i class="bi text-danger {{ in_array($post->id, $likedPostUser, true) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                    <span class="like-count">{{ $post->likes }}</span>
                </div>
                {{--       LIKE --}}
                {{--     COMMENTS --}}
                <a href="{{ route('posts.show', $post) }}#comment_section" style="cursor: pointer"
                   class="text-decoration-none">
                    <i class="bi bi-chat-left-text text-secondary">
                    </i>
                    <span class="text-dark">{{ $post->comments_count }}</span>

                </a>
                @auth
                    {{-- BOOKMARKS --}}
                    <div class="bookmark-button" style="cursor: pointer"
                         data-post-id="{{ $post->id }}"
                         data-url="{{route('profile.bookmarks.store')}}">
                        <i class="ms-3 bi text-warning {{ in_array($post->id, $bookmarkPostUser, true) ? 'bi-bookmark-fill' : 'bi-bookmark' }}"></i>
                    </div>

                @endauth
            </div>
            {{--                            VIEWS --}}
            <i style="user-select: none; font-size: 1.2rem" class=" bi bi-eye-fill me-2">
                <span class="view-count">{{ $post->views }}</span>
            </i>
        </div>

    </div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Bootstrap</strong>
            <small>11 mins ago</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>
<!-- MODAL UPDATE POST-->
<div class="modal fade" id="update_post{{ $post->id }}" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('posts.update', $post) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        <label for="postTitle" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title }}">
                    </div>
                    <div class="mb-3">
                        <label for="postDescription" class="form-label">Description</label>
                        <input type="text" name="description" class="form-control"
                               value="{{ $post->description }}">
                    </div>
                    <div class="mb-3">
                        <label for="postImage" class="form-label">Image</label>
                        <input type="file" name="image" class="form-control"
                               id="postImage">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                    </button>
                    <input type="submit" class="btn btn-warning" value="Update">
                </form>

            </div>
        </div>
    </div>
</div>
<!-- END MODAL UPDATE POST-->
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
            <form action="{{ route('posts.claims.store',$post) }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <p>Выберите причину жалобы:</p>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason1"
                                   value="Оскорбления и грубое общение">
                            <label class="form-check-label" for="reason1">Оскорбления и грубое
                                общение</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason2"
                                   value="Преследование и травля">
                            <label class="form-check-label" for="reason2">Преследование и травля</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason3"
                                   value="Призывы и одобрение насилия">
                            <label class="form-check-label" for="reason3">Призывы и одобрение
                                насилия</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason4"
                                   value="Запрещенный к публикации контент">
                            <label class="form-check-label" for="reason4">Запрещенный к публикации
                                контент</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason5"
                                   value="Реклама и ссылки">
                            <label class="form-check-label" for="reason5">Реклама и ссылки</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="title" id="reason6"
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
