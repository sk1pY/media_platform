@extends('layouts.app')
@section('title', 'bookmarks')
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
                <th scope="row"><a
                        href="{{ route('posts.show',$bookmark->post->id) }}">{{ $bookmark->post->title }}</a>
                </th>
                <th>
                    <form action="{{ route('bookmarks.destroy',['id' => $bookmark->id]) }}" method="post">
                        @csrf
                        <input class="btn btn-danger" type="submit" value="Удалить">
                    </form>
                </th>

            </tr>
        @endforeach
            </tbody>
        </table>

@endsection
