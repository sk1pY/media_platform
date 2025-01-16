@extends('layouts.app')
@section('content')
    {{-- MAIN CARDS CONTENT --}}
    <div class="card border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-1">
                    <img
                        src="{{$post->user->image? Storage::url('avatarImages/'.$post->user->image):asset('imageAvatar/def.jpg') }}"
                        class="rounded-circle" style="width: 45px; height: 45px;" alt="...">
                </div>
                <div class="col p-0">
                    <div><a class="fw-bold link-dark text-decoration-none"
                            href="{{ route('home.profile.show',$post->user->id) }}">{{ $post->user->name }}</a></div>
                    <small class="text-muted">
                        @if($post->category)
                            <a class="link-secondary active fs-7 text-dark text-decoration-none me-1"
                               href="{{route('categories.show',$post->category->id)}}">{{ $post->category->name }}</a>
                        @endif
                        <?php
                        $date_string = strval($post->created_at);
                        $date = new DateTime($date_string);
                        $current_date = new DateTime();

                        if ($date->format('Y-m-d') == $current_date->format('Y-m-d')) {
                            echo $date->format('H:i');
                        } elseif ($date->format('Y-m-d') == $current_date->modify('-1 day')->format('Y-m-d')) {
                            echo "Вчера";
                        } else {
                            echo $date->format('d F');
                        }
                        ?>
                    </small>
                </div>
            </div>
            <a href="{{ route('posts.show', ['post' => $post->id]) }}"
               class="text-decoration-none text-dark hover-effect">
                <h5 class="card-title mt-3 fs-2">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->description }}...</p>

                <div class="card-img-container">
                    <img src="{{ Storage::url('postImages/'.$post->image) }}" style="width: 100%; height: 290px;"
                         class="card-img-top rounded-3" alt="...">
                </div>
            </a>
            <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                <div id="post-{{ $post->id }}" class="post d-flex align-items-center">
                    <div style="cursor: pointer" class="like-button me-3"
                         data-post-id="{{ $post->id }}">
                        <i class="fa-regular fa-heart red-heart {{ in_array($post->id, $likedPostUser) ? ' fa-solid red-heart' : '' }}">
                            <span class="like-count">{{ $post->likes_count }}</span>
                        </i>
                    </div>
                    <a href="#comentary" style="cursor: pointer" class="text-decoration-none">
                        <i class="fa-regular fa-comment me-1 color_grey">
                            <span class="ms-0">{{ $post->comments_count }}</span>
                        </i>
                    </a>

                    {{-- BOOKMARKS --}}
                    <div style="cursor: pointer" class="bookmark-button "
                         data-bookmark-id="{{ $post->id }}">

                        <i class=" bookmark_button ms-3 bi {{ in_array($post->id,$bookmarkPostUser)? 'bi-bookmark-fill color_grey' : 'bi-bookmark' }}"></i>
                    </div>

                </div>
                {{--                VIEWS--}}
                <i style="font-size: 1.2rem" class="bi bi-eye-fill me-2">
                    <span id="view-number">{{ $post->views }}</span>
                </i>
            </div>
            {{-- Comment Forma --}}
            <form id="comment_section" action="{{ route('comment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-3 mt-3">
                    <textarea class="form-control" id="comment-text" name="text" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>
        {{--FILTER--}}
        <div class="m-2">
            <form action="{{ route('posts.show',$post->id) }}" id="filterForm" method="get">

                <select class="form-select w-25 text-decoration-none" id="rating" name="filter_comments"
                        form="filterForm"
                        onchange="this.form.submit()">

                    <option value="">Выберите фильтр</option>
                    <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }} >Самые новые
                    </option>
                    <option value="old" {{ request('filter') === 'old' ? 'selected' : '' }}> Самые старые
                    </option>
                    {{--                    <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>Популярные--}}
                    {{--                    </option>--}}
                </select></form>
        </div>
        {{--FILTER--}}
        {{-- COMMENTS SECTION --}}
        @foreach($comments as $comment)

            <div class="card border-0 m-2 rounded-4 " style="background-color:whitesmoke">
                <div class="card-body">
                    <div class="row align-items-center ">
                        <div class="d-flex align-items-center">
                            <img
                                src="{{$comment->user->image? Storage::url('avatarImages/'.$comment->user->image):asset('imageAvatar/def.jpg') }}"
                                class="rounded-circle" style="width: 40px; height: 40px;" alt="...">
                            <div class=" ms-2 ">
                                <div class="fw-bold me-2"><a class="fw-bold link-dark text-decoration-none"
                                                             href="{{ route('home.profile.show',['user'=>$comment->user->id]) }}">{{ $comment->user->name }}</a>
                                </div>
                                <div class="text-muted">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class=" d-flex flex-column">
                        <div class="mt-2 me-3">{{ $comment->text }}</div>
                        @auth
                        <div class="d-flex m-2 fs-5 comment">
                            <div class="likedislike-comment-button" data-comment-id="{{ $comment->id }}">
                                <i class="me-2 like_button bi bi-hand-thumbs-up"
                                   data-type="like"
                                   data-comment-id="{{ $comment->id }}"
                                   style="cursor: pointer">
                                    <span class="like-count">{{$comment->like}}</span>
                                </i>
                            </div>
                            <div class="likedislike-comment-button" data-comment-id="{{ $comment->id }}">
                                <i class="dislike_button bi bi-hand-thumbs-down"
                                   data-type="dislike"
                                   data-comment-id="{{ $comment->id }}"
                                   style="cursor: pointer">
                                    <span class="dislike-count">{{$comment->dislike}}</span>
                                </i>
                            </div>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- END MAIN CARDS CONTENT --}}
    <script>
        var likeUrl = "{{ route('comments.like') }}";
    </script>
    <script src="{{ asset('js/like_dislike_comment.js') }}"></script>
    <script>
        var incrementViewsUrl = "{{ route('posts.incrementViews', $post->id) }}";
    </script>
    <script src="{{ asset('js/view.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script>
        var likePostUrl = '{{ route("like_post") }}';
    </script>
    <script src="{{ asset('js/like.js') }}"></script>

@endsection
