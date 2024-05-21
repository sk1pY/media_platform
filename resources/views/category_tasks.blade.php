@extends('layouts.app')
@section('title','todo app')
@section('content')
    @foreach($tasks as $task)
        <div class="card col-5 mx-auto mt-3">
            <img src="{{ Storage::url($task->image) }}" class="card-img-top" width="350px" height="250px" alt="№">
            <div class="card-body">
                <h5 class="card-title"><a href="/task/{{ $task -> id }}">{{ $task -> title }}</a></h5>
                <p class="card-text">{{$task -> description}}</p>
                <p class="card-text"><small class="text-body-secondary">{{$task -> updated_at}}</small></p>
            </div>
        </div>
    @endforeach
@endsection
