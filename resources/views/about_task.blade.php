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
                    <div>
                        @if($post->category)
                            <a class="link-secondary active fs-7 text-dark text-decoration-none"
                               href="/cat/{{ $post->category->name }}">{{ $post->category->name }}</a>
                        @endif
                        <?php
                        $date_string = strval($post->created_at);
                        $date = new DateTime($date_string);
                        $current_date = new DateTime();

                        if ($date->format('Y-m-d') == $current_date->format('Y-m-d')) {
                            echo $date->format('H:i');
                        } elseif ($date->format('Y-m-d') == $current_date->modify('-1 day')->format('Y-m-d')) {
                            echo "Yesterday";
                        } else {
                            echo $date->format('d F');
                        }
                        ?>
                    </div>
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
                    <div style="cursor: pointer" class="like-button me-3" data-post-id="{{ $post->id }}">
                        <i class="fa-regular fa-heart red-heart{{ in_array($post->id, $likedPostUser) ? ' fa-solid red-heart' : '' }}">
                            <span class="like-count">{{ $post->likes_count }}</span>
                        </i>

                    </div>
                    <a href="#comentary" style="cursor: pointer" class="text-decoration-none">
                        <i class="fa-regular fa-comment me-1">
                            <span class="ms-0">{{ $post->comments_count }}</span>
                        </i>

                    </a>

                    {{-- BOOKMARKS --}}
                    <div style="cursor: pointer" class="bookmark-button me-3" data-bookmark-id="{{ $post->id }}">
                        <i class="ms-3 fa-regular fa-bookmark yellow-bookmark{{ in_array($post->id, $bookmarkPostUser) ? ' fa-solid yellow-bookmark' : '' }}"></i>
                    </div>

                </div>
{{--                VIEWS--}}
                <i style="font-size: 1.2rem" class="bi bi-eye-fill me-2">
                    <span id="view-number">{{ $post->views }}</span>
                </i>
            </div>{{-- Comment Forma --}}
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <div class="mb-3 mt-3">
                    <textarea class="form-control" id="comment-text" name="text" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>

        {{-- COMMENTS SECTION --}}
        @foreach($comments as $comment)
            <div class="card border-0 m-3">
                <div class="card-body">
                    <div class="row align-items-center ">
                        <div class="d-flex align-items-center">
                            <img
                                src="{{$comment->user->image? Storage::url('avatarImages/'.$comment->user->image):asset('imageAvatar/def.jpg') }}"
                                class="rounded-circle" style="width: 40px; height: 40px;" alt="...">
                            <div class=" ms-2 ">
                                <div class="fw-bold me-2"><a class="fw-bold link-dark text-decoration-none" href="{{ route('home.profile.show',['user'=>$comment->user->id]) }}">{{ $comment->user->name }}</a></div>
                                <div class="text-muted">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">{{ $comment->text }}</div>

                </div>
            </div>
            <script>

                $(document).ready(function () {
                    $('.like-button').on('click', function () {
                        var postId = $(this).data('post-id');
                        var button = $(this);
                        var likeCountSpan = button.closest('.post').find('.like-count');
                        var heartIcon = button.find('.fa-heart'); // Иконка сердца

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

                $(document).ready(function () {
                    $('.bookmark-button').on('click', function () {
                        var postId = $(this).data('bookmark-id');
                        var button = $(this);
                        var bookmarkButton = button.find('.fa-bookmark');

                        $.ajax({
                            url: '/bookmarks/add',
                            method: 'POST',
                            data: {
                                bookmark_id: postId
                            },
                            success: function (response) {
                                if (response.success) {
                                    //  likeCountSpan.text(response.likes);
                                    if (response.bookmark) {
                                        bookmarkButton.addClass('fa-solid yellow-bookmark');
                                    } else {
                                        bookmarkButton.removeClass('fa-solid ');
                                    }
                                } else {
                                    $('#message').text(response.message).css('color', 'red');
                                }

                            }
                        });
                    });
                });


            </script>

        @endforeach

    </div>
    </div>
    {{-- END MAIN CARDS CONTENT --}}
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $.ajax({
                    url: "{{ route('post.incrementViews', $post->id) }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#view-number').text(data.views);
                    },
                    error: function (xhr, status, error) {
                        console.log("Error: " + error);
                        console.log("Status: " + status);
                        console.log(xhr.responseText);
                    }
                });
            }, 5000);
        });

        $(document).keydown(function (e) {
            if (e.keyCode === 13) {
                $("#commForm").submit();
            }
        });
    </script>
@endsection
