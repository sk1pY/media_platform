@extends('dashboard.layouts.app')
@section('content')
    <h4>Мои комментарии</h4>

    <table id="table" class="table table-sm table-bordered table-striped small">
        <thead>
            <tr class="align-middle">
                <th scope="col" class="col-8 text-center">комментарий</th>
                <th scope="col" class="col-1 text-center">лайки кол-во </th>
                <th scope="col" class="col-1 text-center">Удалить</th>
            </tr>
        </thead>
        <tbody class="tablecontents">
            @foreach ($comments as $comment)
                <tr class="align-middle ">
                    <td>
                        <a class="text-decoration-none text-dark " href="{{ route('posts.show', $comment->post) }}">{{ $comment->text }}</a>
                    </td>
                    <td >
                        {{ $comment->like }}
                    </td>
                    <td class="d-flex justify-content-center">
                        <form action="{{ route('profile.comments.destroy','comment') }}" method="post"
                            class="ms-2">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm text-danger">
                                <i class="bi bi-x"></i>
                            </button>
                        </form>

                    </td>

                </tr>
                <div class="mt-4">
                </div>
            @endforeach
        </tbody>
    </table>
    {{ $comments->links('pagination::bootstrap-5') }}
@endsection
