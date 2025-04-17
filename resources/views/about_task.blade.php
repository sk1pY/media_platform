@extends('layouts.app')
@section('content')
    @include('partials/post_card')
    {{--        FILTER --}}
    <div class="m-2">
        <form action="{{ route('posts.show', $post->id) }}" id="filterForm" method="get">

            <select class="form-select w-25 text-decoration-none" id="rating" name="filter_comments" form="filterForm"
                    onchange="this.form.submit()">
                <option value="">Выберите фильтр</option>
                <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }}>Самые новые
                </option>
                <option value="old" {{ request('filter') === 'old' ? 'selected' : '' }}> Самые старые
                </option>
                <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>Популярные
                </option>
            </select>
        </form>
    </div>
    {{--        FILTER --}}
    @auth
        {{-- Comment Forma --}}
        <form action="{{ route('comment.store') }}" method="POST">
            @csrf
            <input type="hidden" name="post_id" value="{{ $post->id }}">
            <div class="mb-3 mt-3">
                <textarea class="form-control" id="comment-text" name="text" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Отправить</button>
        </form>
    @endauth
    {{--         COMMENTS SECTION --}}
    @foreach ($comments as $comment)
        <div class="card border-0 m-2 rounded-4 " style="background-color:whitesmoke">
            <div class="card-body">
                <div class="row align-items-center ">
                    <div class="d-flex align-items-center">
                        <img
                            src="{{ $comment->user->image ? Storage::url('avatarImages/' . $comment->user->image) : asset('imageAvatar/def.jpg') }}"
                            class="rounded-circle" style="width: 40px; height: 40px;" alt="...">
                        <div class=" ms-2 ">
                            <div class="fw-bold me-2"><a class="fw-bold link-dark text-decoration-none"
                                                         href="{{ route('users.show', ['user' => $comment->user]) }}">{{ $comment->user->name }}</a>
                            </div>
                            <div class="text-muted">{{ $comment->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
                <div class=" d-flex flex-column">
                    <div class="mt-2 me-3">{{ $comment->text }}</div>
                    @auth
                        <div class="d-flex m-2 fs-5 comment">
                            <div class="like-comment-button"
                                 data-comment-id="{{ $comment->id }}"
                                 data-url="{{route('like_comment')}}">
                            <i class="me-2 like_button bi bi-heart"
                               data-comment-id="{{ $comment->id }}"
                               style="cursor: pointer">
                                <span class="like-count">{{ $comment->like }}</span>
                            </i>
                        </div>

                </div>
                @endauth
            </div>
        </div>
        </div>
    @endforeach


    {{-- END MAIN CARDS CONTENT --}}
    <script>
        var likeUrl = "{{ route('comments.like') }}";
    </script>
    <script src="{{ asset('js/like_comment.js') }}"></script>
    <script>
        var incrementViewsUrl = "{{ route('posts.incrementViews', $post->id) }}";
    </script>
    <script src="{{ asset('js/view.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script>
        var likePostUrl = '{{ route('like_post') }}';
    </script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script>
        var subAuthors = @json($subAuthors);
    </script>
    <script src="{{ asset('js/subscribe.js') }}"></script>
@endsection
