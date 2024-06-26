@extends('layouts.app')
@section('title', 'todo app')
@section('content')

    {{-- MODAL WINDOW --}}
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input name="title" type="text" class="form-control" id="exampleFormControlInput1"
                                   placeholder="title">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                      rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            Select a category
                            @if(count($categories) > 0)
                                <select name="cat_name" class="form-select">
                                    <option selected></option>
                                    @foreach($categories as $cat)
                                        <option>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Image</label>
                            <input name="image" type="file" class="form-control" id="exampleFormControlInput2">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="send" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL WINDOW --}}
    <div id="message"></div>
    <div class="container">
        <div class="row">
            {{-- Столбец с категориями --}}
            <div class="col-3  mt-4" style="border-right: 1px solid #ddd; background-color: #f2f2f2">
                <div class="position-sticky">
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
                    </ul>

                    <h1 class="nav-link fs-5 text-dark">Категории</h1>
                    @if(count($categories) > 0)
                        @foreach($categories as $cat)
                            <li class="list-unstyled">
                                <a class="link-secondary active fs-5 text-dark text-decoration-none"
                                   href="/cat/{{ $cat->name }}">{{ $cat->name }}</a>
                            </li>

                        @endforeach
                    @endif
                </div>
            </div>
            {{--MAIN CARDS CONTENT--}}
            <div class="col-9 mt-4">
                <div class="row">
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
                                                       href="/cat/{{ $cat->name }}">{{ $task-> category -> name }}
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
                                        <a href="/task/{{ $task->id }}"
                                           class="text-decoration-none text-dark hover-effect">
                                            <h5 class="card-title mt-3">{{ $task->title }}</h5>
                                            <p class="card-text">{{ substr($task->description, 0, 100) }}...</p>

                                    <div class="card-img-container">
                                        <img src="{{ Storage::url($task->image) }}" style="width: 100%; height: 290px;" class="card-img-top rounded-3" alt="...">
                                    </div>
                                        </a>
                                    <div class="d-flex justify-content-between align-items-center mt-3 ms-1 ">
                                        <div id="task-{{ $task->id }}" class="task d-flex align-items-center">
                                            <div class="like-button me-3" data-task-id="{{ $task->id }}">
                                                <i class="fa-regular fa-heart red-heart{{ in_array($task->id, $likedTaskIds) ? ' fa-solid red-heart' : '' }}"></i>
                                                <span class="like-count">{{ $task->likes_count }}</span>
                                            </div>
                                            <a href="task/{{ $task->id }}" class="text-decoration-none">
                                                <i class="fa-regular fa-comment me-1"></i>
                                            </a>
                                            <span>{{ $task->comments_count }}</span>
                                            <i style="height: 12px;" class=" fa-regular fa-bookmark ms-3"></i>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            {{--END MAIN CARDS CONTENT--}}

        </div>
    </div>
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


    </script>
@endsection
