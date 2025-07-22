<div id="card-{{$post->id}}" class="card border-0 mb-3 rounded-3 ">
    <div class="card-body">
        <div class="row align-items-center ">
            <div class="col-auto">
                <img
                    src="{{ $post->user->image ? Storage::url('avatarImages/' . $post->user->image) : asset('default_images/defaultAvatar.jpg') }}"
                    class="rounded-circle" style="width: 45px; height: 45px;"
                    alt="{{ Storage::url('avatarImages/' . $post->user->image) }}">
            </div>
            <div class="col p-0">
                <div>
                    <a class="fw-bold link-dark text-decoration-none "
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
                        @if ($post->user->id !== auth()->id())
                            <div class="d-flex sub-button me-3" style="height: 35px; cursor: pointer;"
                                 data-author-id="{{ $post->user->id }}"
                                 data-url="{{route('subscribe')}}" +>
                                <button
                                    class=" btn btn-sm rounded-4  ms-3 {{in_array($post->user->id, $subAuthors, true)?'btn-outline-secondary':'btn-secondary '}}">
                                    {{in_array($post->user->id, $subAuthors, true)?'Отписаться':'Подписаться'}}</button>
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
                                <li>
                                    <a data-bs-toggle="modal" data-bs-target="#update_post{{$post->id}}"
                                       class="dropdown-item">Изменить</a>
                                </li>
                            @endcan
                            @can('destroy',$post)
                                <li>
                                    <form action="{{ route('profile.posts.destroy',$post) }}" method="post">
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
        {{--        MAIN--}}
        <a href="{{ route('posts.show',$post) }}">
            <div class="mt-3 mb-2">
            <span class="text-decoration-none text-dark hover-effect fs-4 fw-bold">
                {{ $post->title }}

            </div>

            <p class="card-text trix-content mb-2 fs-6">
                {!!  ($postShowFlag ?? false)?  $post->description
                :$post->short_description !!}
            </p>

        </a>
            <div class="card-img-container">
                <img
                    src="{{ $post->image?Storage::url('postImages/'.$post->image):asset('default_images/defaultImage.png') }}"
                    data-zoomable
                    style=" height: 350px"
                    alt="image_not_found"
                    class="card-img-top rounded-3">
            </div>

        {{--        MAIN--}}
        <div class="d-flex justify-content-between align-items-center mt-3 ms-2 fs-6">
            <div class="d-flex align-items-center">
                {{--       LIKE --}}
                <div id="like-button" class=" like-button me-3" style="cursor:pointer"
                     data-post-id="{{ $post->id }}"
                     data-url="{{ route('posts.like') }}">
                    <i class=" bi text-danger {{ in_array($post->id, $likedPostUser, true) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
@include('partials.modal.update_post')
@include('partials.modal.claim_post')

