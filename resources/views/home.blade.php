@extends('layouts.app')

@section('content')
    <div class="container ">
        <div class="row p-4">
            <div class="col-3">
                <div class="d-flex align-items-center mb-3">
                    <img class="rounded-circle" style="width: 90px; height:90px" src="{{ Storage::url($user->image) }}"
                         alt="User Image">
                    <span class="ms-3">{{ Auth::user()->name }}</span>
                </div>
                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#Modal"
                        style="width: 100%;">
                    Edit Profile
                </button>
                {{-- MODAL EDIT PROFILE WINDOW --}}
                <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="exampleModalLabel">Edit Profile</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('home.update.profile', $user->id) }}"
                                      enctype="multipart/form-data" method="POST">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Name</label>
                                        <input name="name" type="text" class="form-control"
                                               id="exampleFormControlInput1" value="{{ $user->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput2" class="form-label">Email</label>
                                        <input name="email" type="email" class="form-control"
                                               id="exampleFormControlInput2" value="{{ $user->email }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput3" class="form-label">Image</label>
                                        <input name="image" type="file" class="form-control"
                                               id="exampleFormControlInput3">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                    <input type="submit" value="Update" class="btn btn-primary">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END MODAL EDIT PROFILE WINDOW --}}
            </div>
            <div class="col-9">

                <div class="row row-cols-1 row-cols-md-3 g-4">
                    @foreach($tasks as $task)
                        <div class="col">
                            <div class="card h-100">
                                <img src="{{ Storage::url($task->image) }}" class="card-img-top" alt="Task Image">
                                <div class="card-body" style="max-height: 200px; overflow: hidden;">
                                    <h5 class="card-title"><a href="/task/{{ $task->id }}">
                                            {{ implode(" ",array_slice(explode(" ",$task->title),0,3)) }}
                                        </a></h5>
                                    <p class="card-text">
                                        {{ implode(" ",array_slice(explode(" ",$task->description),0,10)) }}
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <form action="{{ route('delete', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <input class="btn btn-outline-danger" type="submit" value="Delete">
                                    </form>
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                            data-bs-target="#editTaskModal{{ $task->id }}">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- MODAL UPDATE POST-->
            @foreach($tasks as $task)
                <div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Task</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('home.update.task', $task->id) }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="mb-3">
                                        <label for="taskTitle{{ $task->id }}" class="form-label">Title</label>
                                        <input type="text" name="title" class="form-control"
                                               id="taskTitle{{ $task->id }}" value="{{ $task->title }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="taskDescription{{ $task->id }}"
                                               class="form-label">Description</label>
                                        <input type="text" name="description" class="form-control"
                                               id="taskDescription{{ $task->id }}" value="{{ $task->description }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="taskImage{{ $task->id }}" class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control"
                                               id="taskImage{{ $task->id }}">
                                    </div>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                    <input type="submit" class="btn btn-warning" value="Update">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <!-- END MODAL UPDATE POST-->
        </div>

@endsection
