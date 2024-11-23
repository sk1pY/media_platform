@extends('layouts.app')

@section('category')
    <div class="position-sticky" style="top: 75px; border-right: 1px solid #ddd; background-color: #f2f2f2;">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="link-secondary nav-link active fs-5 text-dark" aria-current="page" href="#">
                    <i class="fa-solid fa-fire"></i> Популярное
                </a>
            </li>
            <li class="nav-item">
                <a class="link-secondary nav-link active fs-5 text-dark" aria-current="page" href="#">
                    <i class="fa-regular fa-clock"></i> Новое
                </a>
            </li>
            <li class="nav-item">
                <a class="link-secondary nav-link active fs-5 text-dark" aria-current="page" href="#">
                    <i class="fa-regular fa-clipboard"></i> Моя лента
                </a>
            </li>

            <h1 class="nav-link fs-5 text-dark mt-3">Категории</h1>
            @if(count($categories) > 0)
                @foreach($categories as $cat)
                    <li>
                        <a class="link-secondary active fs-5 text-dark text-decoration-none" href="/cat/{{ $cat->name }}">{{ $cat->name }}</a>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
@endsection

@section('content')
    {{-- MAIN CARDS CONTENT --}}
    <div class="card border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-1">
                    <img  src="{{$task->user->image? Storage::url($task->user->image):asset('imageAvatar/def.jpg') }}" class="rounded-circle" style="width: 45px; height: 45px;" alt="...">
                </div>
                <div class="col pl-0">
                    <div><a class="fw-bold link-dark text-decoration-none" href="{{ route('home',$task->user->id) }}">{{ $task->user->name }}</a></div>
                    <div>
                        @if($task->category)
                            <a class="link-secondary active fs-7 text-dark text-decoration-none" href="/cat/{{ $task->category->name }}">{{ $task->category->name }}</a>
                        @endif
                        <?php
                        $date_string = strval($task->created_at);
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
            <a href="{{ route('task.about', ['id' => $task->id]) }}" class="text-decoration-none text-dark hover-effect">
                <h5 class="card-title mt-3">{{ $task->title }}</h5>
                <p class="card-text">{{ $task->description }}...</p>

                <div class="card-img-container">
                    <img src="{{ Storage::url('taskImages/'.$task->image) }}" style="width: 100%; height: 290px;" class="card-img-top rounded-3" alt="...">
                </div>
            </a>
            <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                <div id="task-{{ $task->id }}" class="task d-flex align-items-center">
                    <div style="cursor: pointer" class="like-button me-3" data-task-id="{{ $task->id }}">
                        <i class="fa-regular fa-heart red-heart{{ in_array($task->id, $likedTaskUser) ? ' fa-solid red-heart' : '' }}">
                            <span class="like-count">{{ $task->likes_count }}</span>
                        </i>
                    </div>
                    <a href="#comentary" style="cursor: pointer" class="text-decoration-none">
                        <i class="fa-regular fa-comment me-1">
                            <span class="ms-0">{{ $task->comments_count }}</span>
                        </i>
                    </a>
                    {{-- BOOKMARKS --}}
                    <div style="cursor: pointer" class="bookmark-button me-3" data-bookmark-id="{{ $task->id }}">
                        <i class="ms-3 fa-regular fa-bookmark yellow-bookmark{{ in_array($task->id, $bookmarkTaskUser) ? ' fa-solid yellow-bookmark' : '' }}"></i>
                    </div>
                </div>
            </div>{{-- Comment Forma --}}
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <input type="hidden" name="task_id" value="{{ $task->id }}">
                <div class="mb-3 mt-3">
                    <label id ="comentary"  for="comment-text" class="form-label">комментарии</label>


                    <textarea class="form-control" id="comment-text" name="text" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        </div>

        {{-- COMMENTS SECTION --}}
        <div class="card border-0   ">
            <div class="card-body">
                {{-- Loop through comments --}}
                @foreach($comments as $comment)
                    <div class="row align-items-center mb-3">
                        <div class="col-auto">
                            <img src="{{ Storage::url($comment->user->image) }}" class="rounded-circle" style="width: 40px; height: 40px;" alt="...">
                        </div>
                        <div class="col">
                            <div class="fw-bold">{{ $comment->user->name }}</div>
                            <p>{{ $comment->text }}</p>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    {{-- END MAIN CARDS CONTENT --}}
    <script>

        $(document).ready(function () {
            $('.like-button').on('click', function () {
                var taskId = $(this).data('task-id');
                var button = $(this);
                var likeCountSpan = button.closest('.task').find('.like-count');
                var heartIcon = button.find('.fa-heart'); // Иконка сердца

                $.ajax({
                    url: '/like-task',
                    method: 'POST',
                    data: {
                        task_id: taskId,
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
                var taskId = $(this).data('bookmark-id');
                var button = $(this);
                var bookmarkButton = button.find('.fa-bookmark');

                $.ajax({
                    url: '/bookmarks/add',
                    method: 'POST',
                    data: {
                        bookmark_id: taskId
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
@endsection
