@extends('layouts.app')

@section('content')
    <div class="position-relative mb-3" >
        <img style="width: 100%; height: 290px"  src="{{Storage::url('categoryImages/'.$category->image)}}" alt="123" >

        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
            <span class="fs-1">{{ $category->name }}</span>
        </div>
    </div>

    {{--MAIN CARDS CONTENT--}}
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-1">
                            <img  src="{{$post->user->image? Storage::url('avatarImages/'.$post->user->image):asset('imageAvatar/def.jpg') }}"
                                class="rounded-circle"
                                style="width: 45px; height: 45px;"
                                alt="...">
                        </div>
                        <div class="col pl-0">
                            <div><a class="fw-bold link-dark text-decoration-none"
                                    href="{{ route('home.profile.show',$post-> user -> id) }}">{{ $post -> user->name }}</a></div>
                            <div>
                                @if($post->category)
                                    <a class="link-secondary active fs-7 text-dark text-decoration-none"
                                       href="{{route('categories.show',$post-> category->id)}}">{{ $post-> category -> name }}
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
                    <a href="{{ route('posts.show', ['post' => $post ->  id]) }}"
                       class="text-decoration-none text-dark hover-effect">
                        <h5 class="card-title mt-3">{{ $post->title }}</h5>
                        <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                        <div class="card-img-container">
                            <img src="{{ Storage::url('postImages/'.$post->image) }}"
                                 style="width: 100%; height: 290px" class="card-img-top rounded-3"
                                 alt="...">
                        </div>
                    </a>
                    {{--                    LIKE--}}
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
                                <i class="fa-regular fa-comment me-1">
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
                    </div>

                </div>
            </div>
        @endforeach
    @endif
    {{--END MAIN CARDS CONTENT--}}
    <script>
        {{-- LIKE--}}
        $(document).ready(function () {
            $('.like-button').on('click', function () {
                var postId = $(this).data('post-id');
                var likeCountSpan = $(this).closest('.post').find('.like-count');
                var heartIcon = $(this).find('.fa-heart');

                $.ajax({
                    url: '/like-post',
                    method: 'POST',
                    data: {
                        post_id: postId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        if (response.success) {
                            likeCountSpan.text(response.likes);
                            if (response.liked) {
                                heartIcon.addClass('fa-solid red-heart');
                            } else {
                                heartIcon.removeClass('fa-solid ');
                            }
                        } else {
                            $('#message').text(response.message).css('color', 'red');
                        }
                    },
                    error: function () {
                        $('#message').text('An error occurred. Please try again later.').css('color', 'red');
                    }
                });
            });
        });
        {{-- LIKE--}}
        {{--    BOOKMARK--}}
        $(document).ready(function () {
            $('.bookmark-button').on('click', function () {
                var bookmarkId = $(this).data('bookmark-id');
                var bookmarkButton = $(this).find('.fa-bookmark');

                $.ajax({
                    url: '/bookmarks/add',
                    method: 'POST',
                    data: {
                        bookmark_id: bookmarkId
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.bookmark) {
                                bookmarkButton.addClass('fa-solid yellow-bookmark');
                            } else {
                                bookmarkButton.removeClass('fa-solid ');
                            }
                        } else {
                            $('#message').text(response.message).css('color', 'red');
                        }
                    },
                });
            });
        });
        {{--    BOOKMARK--}}
        {{--        SUBSCRIBE--}}
        var subAuthors = @json($subAuthors);
        $(document).ready(function () {
            $('.sub-button').each(function () {
                var subId = $(this).data('author-id');
                if (subAuthors.includes(subId)) {
                    $(this).text('Отписаться').removeClass('btn btn-secondary').addClass(' btn btn-outline-secondary')
                } else {
                    $(this).text('Подписаться').removeClass('btn btn-outline-secondary').addClass('btn btn-secondary');
                }
            });

            $('.sub-button').on('click', function () {
                var subId = $(this).data('author-id');

                $.ajax({
                    url: '/subscribe',
                    method: 'POST',
                    data: {
                        sub_id: subId
                    },
                    success: function (response) {
                        if (response.success) {
                            if (response.sub) {
                                $('.sub-button[data-author-id="' + subId + '"]').text('Отписаться').removeClass('btn btn-secondary').addClass('btn btn-outline-secondary');
                            } else {

                                $('.sub-button[data-author-id="' + subId + '"]').text('Подписаться').removeClass('btn btn-outline-secondary').addClass('btn btn-secondary');
                            }
                        } else {
                            $('#message').text(response.message).css('color', 'red');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Произошла ошибка при добавлении/удалении закладки');
                    }
                });
            });
        });
        {{--        SUBSCRIBE--}}
    </script>
@endsection

