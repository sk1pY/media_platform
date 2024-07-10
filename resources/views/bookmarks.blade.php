@extends('layouts.app')

@section('title', 'todo app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @foreach ($bookmarks as $bookmark)
                    <p>{{ $bookmark->task->title }}</p>
                    <p>{{ $bookmark->task->description }}</p>
                    <form action="{{ route('bookmarks.destroy',['id' => $bookmark->id]) }}" method="post">
                        @csrf
                        <input class="btn btn-success" type="submit">
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection
