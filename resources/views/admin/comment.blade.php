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
    <table class="table table-sm table-bordered table-striped small">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col" class="col-1">Пост</th>
            <th scope="col " class="col-1">Комментатор</th>
            <th scope="col " class="col">Комментарий</th>
            <th scope="col" class="col-1">Edit/Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $comments as $comment )
            <tr class="align-middle">

                <td class=" text-center ">
                    <p>{{ $comment->post->title }}</p>
                </td>
                <td class=" text-center ">
                    <p>{{ $comment->user->name }}</p>
                </td>
                <td class="text-center w-auto " >
                    <p>{{ $comment->text }}</p>
                </td>
                <td>
                    <form action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}" method="post" class="ms-2">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm text-danger">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $comments->links('pagination::bootstrap-5') }}
    </div>
@endsection
