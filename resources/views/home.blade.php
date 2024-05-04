@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                <div class="card-body">--}}
{{--                    @if (session('status'))--}}
{{--                        <div class="alert alert-success" role="alert">--}}
{{--                            {{ session('status') }}--}}
{{--                        </div>--}}
{{--                    @endif--}}

{{--                    {{ __('You are logged in!') }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>
    <h1>Profile </h1>
<table class="table">
    <thead>
    <tr>
        <th scope="col">id</th>
        <th scope="col">title</th>
        <th scope="col">Description</th>
        <th scope="col">Author</th>
        <th scope="col">Delete</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <th scope="row">{{$task -> id}}</th>
            <td><a href="/task/{{$task -> id}}">{{$task -> title}}</a></td>
            <td>{{$task -> description}}</td>
            <td>{{$task -> user -> name}}</td>
            <td>
                <form action = "{{ route('delete',$task->id) }}" method = "post" >
                    @csrf
                    @method('DELETE')
                    <input class="btn btn-danger" type="submit" value="delete">
                </form>
                <form action = "{{ route('update',$task->id) }}" method = "post" >
                    @csrf
                    @method('put')
                    <input class="btn btn-warning" type="submit" value="update">
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
