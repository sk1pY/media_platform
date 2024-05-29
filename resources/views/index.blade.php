@extends('layouts.app')
@section('title', 'todo app')
@section('content')
    {{-- MODAL WINDOW --}}
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Add task</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('create') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input name="title" type="text" class="form-control" id="exampleFormControlInput1"
                                   placeholder="title">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                            <textarea name="description" class="form-control" id="exampleFormControlTextarea1"
                                      rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            Select a category
                            @if(count($categories) > 0)
                                <select name="cat_name" class="form-select">
                                    <option selected></option>
                                    @foreach($categories as $cat)
                                        <option>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Image</label>
                            <input name="image" type="file" class="form-control" id="exampleFormControlInput2">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" value="send" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL WINDOW --}}

    <div class="container">
        <div class="row">
            <div class="col-3 bg-light mt-4" style="border-right: 1px solid #ddd;">
                <div class="position-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active fs-5 text-dark" aria-current="page" href="#">
                            <i class="fa-solid fa-fire"></i> Популярное
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5 text-dark" aria-current="page" href="#">
                            <i class="fa-regular fa-clock"></i> Новое
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fs-5 text-dark" aria-current="page" href="#">
                            <i class="fa-regular fa-clipboard"></i> Моя лента
                        </a>
                    </li>
                </ul>

                    <h1 class="nav-link fs-5 text-dark">Категории</h1>
                @if(count($categories) > 0)
                    @foreach($categories as $cat)
                        <li class="nav-item">
                            <a class="nav-link active fw-bold fs-5 text-dark"
                               href="/cat/{{ $cat->name }}">{{ $cat->name }}</a>
                        </li>
                    @endforeach
                @endif
                </div>
            </div>
            {{-- Task Cards --}}
            <div class="col-9 mt-4">
                <div class="row">
                    @if(count($tasks) > 0)
                        @foreach($tasks as $task)
                            <div class="col-md-8 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="/task/{{ $task->id }}" class="text-decoration-none text-dark hover-effect">{{ $task->title }}</a>
                                        </h5>
                                        <p class="card-text">{{ substr($task->description, 0, 100) }}...</p>
                                    </div>
                                    <div class="card-img-container" style="padding: 20px;">
                                        <img src="{{ Storage::url($task->image) }}" style="width: 100%; height: 290px;" class="card-img-top rounded-3" alt="...">
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $task->updated_at }}</small>
                                            <div>
                                                <a href="#" class="btn btn-sm btn-outline-primary me-1"><i class="fa-regular fa-heart me-1"></i> Like</a>
                                                <a href="#" class="btn btn-sm btn-outline-secondary"><i class="fa-regular fa-comment me-1"></i> Comment</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
