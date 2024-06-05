@extends('admin.index')
@section('title', 'todo app')
@section('content_admin')
    <table class="table ">
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
                    <form action="{{ route('delete',$task->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <input class="btn btn-danger" type="submit" value="delete">
                    </form>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                        Edit
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('home.update',['task => $task -> id']) }}" method="POST">
                                        @csrf
                                        @method('put')
                                        <input type="text" name="title" value="{{ old('title',$task->title) }}">
                                        <input type="text" name="description"
                                               value="{{ old('description',$task->description) }}">
                                        <input type="file" name="image">
                                        <input class="btn btn-warning" type="submit" value="update">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

