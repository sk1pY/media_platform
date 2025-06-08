@extends('layouts.admin')
@section('admin-content')
    <div class="p-3">
        <h4>Посты</h4>
        <hr>
        <table id="table" class="table table-sm table-bordered table-striped small">
            <thead>
            <tr class="text-center align-middle">
                <th scope="col" class="col-6">Title</th>
                <th scope="col" class="col-3">Author</th>
                <th scope="col" class="col-1">status</th>
                <th scope="col" class="col">Actions</th>
            </tr>
            </thead>
            <tbody id="tablecontents">
            @foreach($posts as $post)
                <tr class="align-middle">
                    <td>
                        <img style="width: 50px" alt="logo"
                             src="{{ $post->image?Storage::url('postImages/'.$post->image):asset('default_images/defaultImage.png') }}">
                        <a class="text-decoration-none text-black" href="{{ route('posts.show', $post) }}">
                            {{ $post->title }}
                        </a>
                    </td>
                    <td class="text-center">
                        {{ $post->user ? $post->user->surname . ' ' . $post->user->name : 'Без автора' }}
                    </td>
                    <td class="text-center">
                        <div class="form-check form-switch ">
                            <input
                                    data-id="{{$post->id}}"
                                    data-url="{{route('admin.posts.update.status',$post->id)}}"
                                    class="js-switch form-check-input" type="checkbox" role="switch"
                                    {{$post->status? "checked":""}}>
                        </div>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#update{{ $post->id }}">
                            <i type="submit" class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post"
                              style="display: inline;">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm"
                                    onclick="return confirm('Точно удалить?')">
                                <i type="submit" class="bi bi-x"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <!-- Modal UPDATE -->
                <div class="modal fade" id="update{{ $post->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title" id="staticBackdropLabel">Изменить данные</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <label for="title" class="form-label">Title</label>
                                    <input id="title" class="form-control form-control-sm" name="title"
                                           value="{{ old('title', $post->title) }}">
                                    <input type="hidden" name="user_id" value="{{ $post->user->id }}">
                                    <label for="description" class="form-label">Описание</label>
                                    <textarea class="form-control form-control-sm" id="description" name="description"
                                              rows="3">{{ $post->description }}</textarea>
                                    <label for="category" class="form-label">Категория</label>
                                    <select class="form-control form-control-sm" name="category_id">
                                        <option value="" {{ !$post->category_id ? 'selected' : '' }}>Без категории
                                        </option>
                                        @foreach($categories as $cat)
                                            <option
                                                value="{{ $cat->id }}" {{ $post->category && $post->category->id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="image" class="form-label">Изображение</label>
                                    <input type="file" class="form-control form-control-sm" name="image">
                                    <img src="{{ Storage::url('postImages/' . $post->image) }}" alt="Изображение"
                                         style="width: 30px; height: 30px;">
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success btn-sm">Принять</button>
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                            Закрыть
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>


@endsection
