@extends('layouts.app')
@section('title', 'todo app')
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
                <a class="link-secondary nav-link active fs-5 text-dark" aria-current="page" href="{{ route('myfeed') }}">
                    <i class="fa-regular fa-clipboard"></i> Моя лента
                </a>
            </li>
            <h1 class="nav-link fs-5 text-dark mt-3">Категории</h1>
            @if(count($categories) > 0)

                @foreach($categories as $cat)
                    <li>
                        <a class="link-secondary active fs-5 text-dark text-decoration-none"
                           href="/cat/{{ $cat->name }}">{{ $cat->name }}</a>
                    </li>
                @endforeach
        </ul>
        @endif
    </div>
@endsection
@section('content')
    {{--MAIN CARDS CONTENT--}}
    <h1>Моя лента</h1>
    <br>
    @if(count($tasks) > 0)
        @foreach($tasks as $task)
            <div class="card border-0 mb-4">
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
                            <img src="{{ Storage::url($task->image) }}"
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

@endsection
