@extends('layouts.app')

@section('title', 'todo app')

@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal">
        Add task
    </button>
    <!-- Modal -->
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input name='title' type="text" class="form-control"
                                   id="exampleFormControlInput1" placeholder="title">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea name='description' class="form-control"
                                      id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            Select a category
                            @if(count($categories) > 0)
                                <select name="cat_name" >
                                    <option selected></option>
                                    @foreach($categories as $cat)
                                        <option>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">image</label>
                            <input name='image' type="file" class="form-control"
                                   id="exampleFormControlInput2">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                        </button>
                        <input type="submit" value="send">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">

            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar" style="border-right: 1px solid #ddd;">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        @if(count($categories) > 0)
                            @foreach($categories as $cat)
                                <li class="nav-item">
                                    <a class="nav-link active fw-bold fs-5 text-dark" aria-current="page" href="/cat/{{$cat->name}}">
                                        {{$cat->name}}
                                    </a>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(count($tasks) > 0)
                    <div class="row">
                        @foreach($tasks as $task)
                            <div class="card col-12 col-md-6 col-lg-7 mx-auto mt-3 p-0">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/task/{{ $task->id }}">{{ $task->title }}</a>
                                    </h5>
                                    <small class="text-body-secondary">{{ $task->updated_at }}</small>

                                    <p class="card-text">{{ substr($task->description,0,100) }}...</p>
                                    <p class="card-text">
                                    </p>
                                    <img src="{{ Storage::url($task->image) }}" class="card-img-top img-fluid" style="height: 250px; object-fit: cover;" alt="№">
                                </div>
                            </div>

                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
@endsection
