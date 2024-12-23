@extends('admin.layouts.index')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <table class="table table-sm table-bordered table-striped ">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col" class="col-5">Title</th>
            <th scope="col" class="col-1">Author</th>
            <th scope="col" class="col-2">Edit/Delete</th>

        </tr>
        </thead>
        <tbody>
        @foreach( $posts as $post )
            <tr class="align-middle">
                <td>
                    <img alt="logo" src="{{ Storage::url('postImages/' . $post->image) }}" style="width: 40px; ">
                    <a class="text-decoration-none text-black "
                       href="{{ route('posts.show',['post' => $post ->id] )}}">{{$post -> title}}</a>
                </td>
                <td class=" text-center ">
                    <p>{{$post->user? $post->user->surname.' '.$post->user->name: 'Без автора'}}</p>
                </td>

                <td class="text-center d-flex ">
                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                            data-bs-target="#update.{{$post->id}}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <form action="{{ route('admin.posts.destroy', $post->id)}}" method="post"
                          id>
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm fs-3">
                            <i type="submit" class="bi bi-x"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <!-- Modal -->
            <div class="modal fade" id="update.{{$post->id}}" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить данные книги</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('admin.posts.update',['post'=>$post->id])}}"
                                  method="post">
                                @csrf
                                @method('put')
                                <label for="title" class="form-label">Title</label>
                                <input id="title" class="form-control"  name="title"
                                       value="{{ old('title',$post->title) }}">
                                <input type="hidden" name="user_id" value="{{$post->user->id}}" >

                                <label for="description" class="form-label">Описание</label>
                                <textarea
                                    class="form-control"
                                    id="description"
                                    name="description"
                                    rows="4">{{$post->description}}
                                </textarea>
                                <label for="author" class="form-label">Категория</label>
                                <select class="form-control" name="category_id">
                                    <option value="" {{ !$post->category_id? 'selected' : '' }}>Без категории</option>
                                    @foreach($categories as $cat)

                                        <option
                                            value="{{$cat->id}}"
                                            {{$post->category && $post->category->id == $cat->id? 'selected':''}}>
                                            {{$cat->name}}
                                        </option>
                                    @endforeach
                                </select>


                                <input type="file" name="image">
                                <img src="{{ Storage::url('postImages/'.$post->image) }}" alt="123"
                                     style="width: 40px;height: 40px;">
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Принять
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
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

@endsection
