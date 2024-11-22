@extends('layouts.app')
@section('title', 'todo app')
@section('category')
    <div class="position-sticky" style="top: 75px;  background-color: #f2f2f2;">
        <ul class="nav flex-column">
            <a class=" rounded-pill  nav-link active fs-5 text-dark" aria-current="page" href="#">
                <i class="fa-solid fa-fire "></i> Популярное
            </a>
            <a class="rounded-pill nav-link active fs-5 text-dark" aria-current="page" href="#">
                <i class="fa-regular fa-clock"></i> Новое
            </a>
            <a class="rounded-pill nav-link active fs-5 text-dark" aria-current="page" href="{{ route('myfeed') }}">
                <i class="fa-regular fa-clipboard"></i> Моя лента
            </a>
            <h1 class="fs-6 mt-3 ms-3" style="color: grey;">Темы</h1>

            @if(count($categories) >  0)
                @foreach($categories as $cat)
                    <li class="rounded-pill nav-link d-flex align-items-center ">
                        <img
                            src="https://static.toiimg.com/thumb/msid-75403416,width-1280,height-720,resizemode-4/75403416.jpg"
                            class=" rounded-circle"
                        style="width:30px;height: 30px">
                        <div class="d-flex ">
                            <a class="  nav-link active fs-5 text-dark"
                               href="/cat/{{ $cat->name }}">{{ $cat->name }}</a>
                        </div>
                    </li>
                @endforeach
        </ul>
        @endif
    </div>
@endsection
@section('content')
    {{--MAIN CARDS CONTENT--}}
    @if(count($tasks) > 0)
        @foreach($tasks as $task)
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-1">
                            <img
                                src="{{Auth::user()->image ? Storage::url(Auth::user()->image):asset('imageAvatar/def.jpg') }}"
                                class="rounded-circle"
                                style="width: 45px; height: 45px;"
                                alt="...">
                        </div>
                        <div class="col pl-0">
                            <div><a class="fw-bold link-dark text-decoration-none"
                                    href="{{ route('home',$task-> user -> id) }}">{{ $task -> user->name }}</a></div>
                            <div>
                                @if($task->category)
                                    <a class="link-secondary active fs-7 text-dark text-decoration-none"
                                       href="/cat/{{ $task-> category -> name }}">{{ $task-> category -> name }}
                                    </a>
                                @endif
                                <small class="text-muted">{{ $task->created_at->diffForHumans() }}</small>

                            </div>

                        </div>
                        @auth
                            @if($task -> user -> id != Auth::id())
                                <div class="col-auto">
                                    <div class=" sub-button me-3" style="cursor: pointer"
                                         data-author-id="{{ $task->user->id }}">
                                        <button class=" btn btn-secondary ms-3 btnclass "></button>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <a href="{{ route('task.about', ['id' => $task ->  id]) }}"
                       class="text-decoration-none text-dark hover-effect">
                        <h5 class="card-title mt-3">{{ $task->title }}</h5>
                        <p class="card-text">{{ substr($task->description, 0, 100) }}...</p>

                        <div class="card-img-container">
                            <img src="{{ Storage::url('taskImages/'.$task->image) }}
"
                                 style="width: 100%; height: 290px;" class="card-img-top rounded-3"
                                 alt="...">
                        </div>
                    </a>
                    <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                        <div id="task-{{ $task->id }}" class="task d-flex align-items-center">
                            <div style="cursor: pointer" class="like-button me-3"
                                 data-task-id="{{ $task->id }}">
                                <i class="fa-regular fa-heart red-heart {{ in_array($task->id, $likedTaskUser) ? ' fa-solid red-heart' : '' }}">
                                    <span class="like-count">{{ $task->likes_count }}</span>

                                </i>
                            </div>
                            <a href="{{ route('task.about',['id' => $task-> id]) }}" style="cursor: pointer"
                               class="text-decoration-none">
                                <i class="fa-regular fa-comment me-1">
                                    <span class="ms-0">{{ $task->comments_count }}</span>

                                </i>
                            </a>
                            {{--BOOKMARKS--}}
                            <div style="cursor: pointer" class="bookmark-button me-3"
                                 data-bookmark-id="{{ $task->id }}">
                                <i class="ms-3 fa-regular fa-bookmark yellow-bookmark {{
                                                        in_array($task->id,$bookmarkTaskUser)? 'fa-solid yellow-bookmark' : '' }}"></i>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
    {{--END MAIN CARDS CONTENT--}}
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
                            if (response.bookmark) {
                                bookmarkButton.addClass('fa-solid yellow-bookmark');
                            } else {
                                bookmarkButton.removeClass('fa-solid ');
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
        var subAuthors = @json($subAuthors);

        $(document).ready(function () {
            $('.sub-button').each(function () {
                var subId = $(this).data('author-id');
                if (subAuthors.includes(subId)) {
                    $(this).text('Отписаться').removeClass('btn btn-secondary').addClass(' btn btn-outline-secondary')
                } else {
                    $(this).text('Подписаться').removeClass('btn btn-outline-secondary').addClass('btn btn-secondary');
                    ;
                }
            });

            // Обработчик клика по кнопке
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
                                // Обновляем все кнопки с тем же author-id
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

    </script>
@endsection
