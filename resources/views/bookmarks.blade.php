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
                <a class="link-secondary nav-link active fs-5 text-dark" aria-current="page" href="#">
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
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Delete bookmark</th>

            </tr>
            </thead>
            <tbody>
            @foreach ($bookmarks as $bookmark)
            <tr>
               <th scope="row"> <a href="{{ route('task.about',['id' => $bookmark->task->id]) }}">{{ $bookmark->task->title }}</a></th>
                <th ><form action="{{ route('bookmarks.destroy',['id' => $bookmark->id]) }}" method="post">
                        @csrf
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form></th>

            </tr>
            @endforeach
            </tbody>
        </table>

@endsection
