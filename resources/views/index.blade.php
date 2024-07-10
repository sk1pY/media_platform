@extends('layouts.app')
@section('title', 'todo app')
@section('content')
    <div id="message"></div>
    <div class="container mt-4">
        {{--MAIN CARDS CONTENT--}}
        @if(count($tasks) > 0)
            @foreach($tasks as $task)
                <div class="col-md-8 mb-4">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-1">
                                    <img
                                        src="{{ Storage::url($task->user->image) }}"
                                        class="rounded-circle"
                                        style="width: 45px; height: 45px;"
                                        alt="...">
                                </div>
                                <div class="col pl-0">
                                    <div>{{ $task -> user->name }}</div>
                                    <div>
                                        @if($task->category)
                                            <a class="link-secondary active fs-7 text-dark text-decoration-none"
                                               href="/cat/{{ $task-> category -> name }}">{{ $task-> category -> name }}
                                            </a>
                                        @endif
                                            <?php

                                            $date_string = strval($task->created_at);
                                            $date = new DateTime($date_string);
                                            $current_date = new DateTime();

                                            // Сравниваем дату с текущей датой
                                            if ($date->format('Y-m-d') == $current_date->format('Y-m-d')) {
                                                echo $date->format('H:i');
                                            } elseif ($date->format('Y-m-d') == $current_date->modify('-1 day')->format('Y-m-d')) {
                                                echo "Yesterday";
                                            } else {
                                                echo $date->format('d F'); // Выводим день и месяц
                                            }

                                            ?>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('task.about', ['id' => $task ->  id]) }}"
                               class="text-decoration-none text-dark hover-effect">
                                <h5 class="card-title mt-3">{{ $task->title }}</h5>
                                <p class="card-text">{{ substr($task->description, 0, 100) }}...</p>

                                <div class="card-img-container">
                                    <img src="{{ Storage::url($task->image) }}"
                                         style="width: 100%; height: 290px;" class="card-img-top rounded-3"
                                         alt="...">
                                </div>
                            </a>
                            <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                                <div id="task-{{ $task->id }}" class="task d-flex align-items-center">
                                    <div style="cursor: pointer" class="like-button me-3"
                                         data-task-id="{{ $task->id }}">
                                        <i class="fa-regular fa-heart red-heart{{ in_array($task->id, $likedTaskUser) ? ' fa-solid red-heart' : '' }}">
                                            <span class="like-count">{{ $task->likes_count }}</span>

                                        </i>
                                    </div>
                                    <a href="task/{{ $task->id }}" style="cursor: pointer" class="text-decoration-none">
                                        <i class="fa-regular fa-comment me-1">
                                            <span class="ms-0">{{ $task->comments_count }}</span>

                                        </i>
                                    </a>
                                    {{--BOOKMARKS--}}
                                    <div style="cursor: pointer" class="bookmark-button me-3"
                                         data-bookmark-id="{{ $task->id }}">
                                        <i class="ms-3 fa-regular fa-bookmark yellow-bookmarkч{{
                                                        in_array($task->id,$bookmarkTaskUser)? 'fa-solid yellow-bookmark' : '' }}"></i>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{--END MAIN CARDS CONTENT--}}


    <script>
        // public/js/like.js
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

                    },
                    error: function (xhr, status, error) {
                        // Обработка ошибки
                        console.error('Произошла ошибка при добавлении/удалении закладки');

                        // Дополнительные действия, если нужно
                    }
                });
            });
        });


    </script>
@endsection
