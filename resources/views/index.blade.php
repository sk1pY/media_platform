@extends('layouts.app')
@section('title','todo app')
@section('content')
    @if( count($tasks)>0 )
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
        </div>
    @endif

    @if ( session('success') )
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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

    @endif
@endsection
