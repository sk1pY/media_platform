@extends('layouts.app')
@section('title', 'Новое')
@section('content')

    {{-- MAIN CARDS CONTENT --}}
    @forelse($posts as $post)
        <div class="card border-0 mb-4">
            <div class="card-body">
                <div class="row align-items-center ">
                    <div class="col-auto ">
                        <img src="{{ $post->user->image ? Storage::url('avatarImages/' . $post->user->image) : asset('imageAvatar/def.jpg') }}"
                            class="rounded-circle" style="width: 45px; height: 45px;"
                            alt="{{ Storage::url('avatarImages/' . $post->user->image) }}">
                    </div>
                    <div class="col p-0">
                        <div><a class="fw-bold link-dark text-decoration-none "
                                href="{{ route('home.profile.show', $post->user->id) }}">
                                {{ $post->user->name }}
                            </a>
                        </div>
                        <div>
                            @if ($post->category)
                                <a class="link-secondary active fs-7 text-dark text-decoration-none me-2"
                                    href="{{ route('categories.show', $post->category->id) }}">
                                    {{ $post->category->name }}
                                </a>
                            @endif
                            <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>

                        </div>

                    </div>
                    @auth

                        <div class="col-auto d-flex ">
                            <div class="dropdown">
                                <a style="cursor: pointer; color: #595959;" class="custom-dropdown text-decoration-none "
                                    data-bs-toggle="dropdown"><i class="bi bi-three-dots text-center"
                                        style="font-size: 27px;"></i></a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('posts.hide', $post->id) }}" method="post">
                                            @csrf
                                            <input class="dropdown-item" type="submit" name="hidden" value="Показаать">
                                        </form>
                                    <li><a class="dropdown-item" href="#">Пожаловаться</a></li>
                                </ul>
                            </div>
                        </div>

                    @endauth
                </div>
                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark hover-effect">
                    <h5 class="card-title mt-3">{{ $post->title }}</h5>
                    <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                    <div class="card-img-container">
                        <img src="{{ Storage::url('postImages/' . $post->image) }}" style="width: 100%; height: 290px"
                            class="card-img-top rounded-3" alt="...">
                    </div>
                </a>
                {{--       LIKE --}}
                <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                    <div id="post-{{ $post->id }}" class="post d-flex align-items-center">
                        <div style="cursor: pointer" class="like-button me-3" data-post-id="{{ $post->id }}">
                            <i
                                class="fa-regular fa-heart red-heart
                        {{ in_array($post->id, $likedPostUser) ? ' fa-solid red-heart' : '' }}">
                                <span class="like-count">{{ $post->likes }}</span>

                            </i>
                        </div>
                        {{--                    LIKE --}}
                        {{--                            COMMENTS --}}
                        <a href="{{ route('posts.show', ['post' => $post->id]) }}#comment_section" style="cursor: pointer"
                            class="text-decoration-none">
                            <i class="fa-regular fa-comment me-1 color_grey">
                                <span class="ms-0">{{ $post->comments_count }}</span>
                            </i>
                        </a>
                        {{-- BOOKMARKS --}}
                        <div style="cursor: pointer" class="bookmark-button me-3" data-bookmark-id="{{ $post->id }}">

                            <i
                                class="bookmark_button ms-3 bi {{ in_array($post->id, $bookmarkPostUser) ? 'bi-bookmark-fill color_grey' : 'bi-bookmark' }}"></i>
                        </div>

                    </div>
                    {{--                            VIEWS --}}
                    <i style="font-size: 1.2rem" class=" bi bi-eye-fill me-2">
                        <span id="view-number">{{ $post->views }}</span>
                    </i>
                </div>

            </div>
        </div>
    @empty
        <h3>
            Посты отсутсвуют
            <i class="bi bi-emoji-frown"></i>
        </h3>
    @endforelse

    {{-- END MAIN CARDS CONTENT --}}

@endsection
