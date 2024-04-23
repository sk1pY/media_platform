@extends('base.base')
@section('title','todo app')
@section('content')
    <nav class="nav navbar  navbar-light bg-light">
        <form action="{{ route('destroy_all') }}" method="post">
            @csrf
            @method('DELETE')
            <input class="btn btn-danger" type="submit" value="DELETE ALL">
        </form>
        <form action="{{ route('create') }}" method="post">
            @csrf
            <input type="text" name="title">
            <input type="text" name="description">
            <input class="btn btn-info" type="submit">
        </form>
    </nav>
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
                <td><a href="/task/{{$post -> id}}">{{$post -> title}}</a></td>
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
