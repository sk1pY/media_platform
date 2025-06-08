@extends('layouts.home')
@section('home-content')
    <h4>Мои комментарии</h4>
    <div class="bg-white p-3 rounded-3">
        <table id="table" class="table table-sm table-bordered  small">
            <thead>
            <tr class="align-middle">
                <th scope="col" class="col-8 text-center">комментарий</th>
                <th scope="col" class="col-1 text-center">лайки кол-во</th>
                <th scope="col" class="col-1 text-center">Удалить</th>
            </tr>
            </thead>
            <tbody class="tablecontents">
            @foreach ($comments as $comment)
                <tr class="align-middle ">
                    <td>
                        <a class="text-decoration-none text-dark "
                           href="{{ route('posts.show', $comment->post) }}">{{ $comment->text }}</a>
                    </td>
                    <td>
                        {{ $comment->like }}
                    </td>
                    <td class="text-center d-flex">
                        <button class="btn btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#updateComment{{ $comment->id }}">
                            <i type="submit" class="bi bi-pencil-square"></i>
                        </button>
                        <form action="{{ route('profile.comments.destroy',$comment) }}" method="post"
                              class="ms-2">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm"
                                    onclick="return confirm('Точно удалить?')">
                                <i type="submit" class="bi bi-x"></i>
                            </button>
                        </form>
                    </td>

                </tr>
                <!-- Modal  UPD comment-->
                <div class="modal fade" id="updateComment{{$comment->id}}" tabindex="-1"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="myForm" action="{{route('profile.comments.update',$comment)}}"
                                      method="post">
                                    @csrf
                                    @method('put')
                                    text comment
                                    <textarea class="form-control" rows="4" cols="50" type="text" name="text">{{ old('text',$comment->text) }}</textarea>

                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                </button>
                                <button form="myForm" type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </tbody>
        </table>
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>

@endsection
