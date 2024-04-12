@extends('base.base')
@section('title','todo app')
@section('content')
    <nav class="nav navbar  navbar-light bg-light">
        <form action="{{ route('create') }}" method="post">
            @csrf
            <input type="text" name="title">
            <input type="text" name="description">
            <input class="btn btn-info" type="submit">
        </form>
    </nav>
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
        @foreach($posts as $post)
            <tr>
                <th scope="row">{{$post -> id}}</th>
                <td>{{$post -> title}}</td>
                <td>{{$post -> description}}</td>
                <td>{{$post -> user -> name}}</td>
                <td>
                    <form action = "{{ route('delete',$post->id) }}" method = "post" >
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-danger" type="submit" value="delete">
                    </form>
                    <form action = "{{ route('update',$post->id) }}" method = "post" >
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
