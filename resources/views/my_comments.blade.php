@extends('layouts.app')
@section('content')
    <h1>Мои комментарии</h1>

    <table id="table" class="table table-sm table-bordered table-striped small">
        <thead>
        <tr class="align-middle">
            <th scope="col" class="col-8 text-center">комментарий</th>
            <th scope="col" class="col-1 text-center">лайки кол-во </th>
            <th scope="col" class="col-1 text-center">Изменить/Удалить</th>
        </tr>
        </thead>
        <tbody class="tablecontents">
        @foreach( $comments as $comment )
            <tr class="align-middle ">

                <td>
                    <a class=""
                        href="{{ route('posts.show',$comment->post->id) }}">{{$comment->text}}</a>
                </td>
                <td>
                    {{$comment->like}}
                </td>
                <td class="d-flex justify-content-center">
{{--                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $category->id }}">--}}
{{--                        <i class="bi bi-pencil-square"></i>--}}
{{--                    </button>--}}

                    <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="post" class="ms-2">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm text-danger">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
{{--                    --}}{{--                    MODAL--}}
{{--                    <div class="modal fade" id="modal-{{$category->id}}" data-bs-backdrop="static"--}}
{{--                         data-bs-keyboard="false"--}}
{{--                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">--}}
{{--                        <div class="modal-dialog">--}}
{{--                            <div class="modal-content">--}}
{{--                                <div class="modal-header">--}}
{{--                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">информация о пользователе</h1>--}}
{{--                                </div>--}}
{{--                                <div class="modal-body">--}}
{{--                                    <form id="formChangeTitle-{{$category->id}}"--}}
{{--                                          action="{{ route('admin.categories.update',['category'=>$category->id]) }}"--}}
{{--                                          method="post"--}}
{{--                                          enctype="multipart/form-data"--}}
{{--                                    >--}}
{{--                                        @csrf--}}
{{--                                        @method('patch')--}}
{{--                                        <input class="form-control" type="text" name="name" value="{{$category->name}}">--}}
{{--                                        <input type="file" name="image">--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                                <div class="modal-footer">--}}
{{--                                    <button form="formChangeTitle-{{$category->id}}" type="submit"--}}
{{--                                            class="btn btn-success">Принять--}}
{{--                                    </button>--}}
{{--                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </td>

            </tr>
            <div class="mt-4">
            </div>
        @endforeach
        </tbody>
    </table>
    {{ $comments->links('pagination::bootstrap-5') }}


@endsection
