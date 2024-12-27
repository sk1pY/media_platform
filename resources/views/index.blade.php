@extends('layouts.app')
@section('content')
    {{--FILTER--}}
    <div class="mb-2">
        <form action="{{ route('index') }}" id="filterForm" method="get">

            <select class="form-select w-25" id="rating" name="filter" form="filterForm"
                    onchange="this.form.submit()">

                <option value="">Выберите фильтр</option>
                <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }} >Самые новые
                </option>
                <option value="old" {{ request('filter') === 'old' ? 'selected' : '' }}> Самые старые
                </option>
                <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>Популярные
                </option>
            </select></form>
    </div>
    {{--FILTER--}}
    {{--MAIN CARDS CONTENT--}}
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <div class="row align-items-center ">
                        <div class="col-auto ">
                            <img
                                src="{{$post->user->image? Storage::url('avatarImages/'.$post->user->image):asset('imageAvatar/def.jpg') }}"
                                class="rounded-circle"
                                style="width: 45px; height: 45px;"
                                alt="...">
                        </div>
                        <div class="col p-0">
                            <div><a class="fw-bold link-dark text-decoration-none "
                                    href="{{ route('home.profile.show',$post-> user -> id) }}">
                                    {{ $post -> user->name }}
                                </a>
                            </div>
                            <div>
                                @if($post->category)
                                    <a class="link-secondary active fs-7 text-dark text-decoration-none me-2"
                                       href="{{ route('categories.show',$post-> category -> id) }}">
                                        {{ $post-> category -> name }}
                                    </a>
                                @endif
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>

                            </div>

                        </div>
                        @auth
                            @if($post -> user -> id != Auth::id())
                                <div class="col-auto">
                                    <div class=" sub-button me-3" style="cursor: pointer"
                                         data-author-id="{{ $post->user->id }}">
                                        <button class=" btn btn-secondary ms-3 btnclass "></button>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <a href="{{ route('posts.show',$post->id)}}"
                       class="text-decoration-none text-dark hover-effect">
                        <h5 class="card-title mt-3">{{ $post->title }}</h5>
                        <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                        <div class="card-img-container">
                            <img src="{{ Storage::url('postImages/'.$post->image) }}"
                                 style="width: 100%; height: 290px" class="card-img-top rounded-3"
                                 alt="...">
                        </div>
                    </a>
                    {{--       LIKE--}}
                    <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                        <div id="post-{{ $post->id }}" class="post d-flex align-items-center">
                            <div style="cursor: pointer" class="like-button me-3"
                                 data-post-id="{{ $post->id }}">
                                <i class="fa-regular fa-heart red-heart {{ in_array($post->id, $likedPostUser) ? ' fa-solid red-heart' : '' }}">
                                    <span class="like-count">{{ $post->likes_count }}</span>

                                </i>
                            </div>
                            {{--                    LIKE--}}
                            <a href="{{ route('posts.show',['post' => $post-> id]) }}" style="cursor: pointer"
                               class="text-decoration-none">
                                <i class="fa-regular fa-comment me-1" style="color:#595959">
                                    <span class="ms-0">{{ $post->comments_count }}</span>

                                </i>
                            </a>
                            {{--BOOKMARKS--}}
                            <div style="cursor: pointer" class="bookmark-button me-3"
                                 data-bookmark-id="{{ $post->id }}">
                                <i class="ms-3 fa-regular fa-bookmark yellow-bookmark {{
                                                        in_array($post->id,$bookmarkPostUser)? 'fa-solid yellow-bookmark' : '' }}"></i>
                            </div>

                        </div>
                        {{--                            VIEWS--}}
                        <i style="font-size: 1.2rem" class=" bi bi-eye-fill me-2">
                            <span id="view-number">{{ $post->views }}</span>
                        </i>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
    {{--END MAIN CARDS CONTENT--}}

    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script> var subAuthors = @json($subAuthors); </script>
    <script src="{{ asset('js/subscribe.js') }}"></script>

@endsection
