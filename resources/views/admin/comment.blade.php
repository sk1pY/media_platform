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
    <table id="table" class="table table-sm table-bordered table-striped small">
        <thead>
        <tr class="text-center align-middle">
            <th scope="col" class="col-5">Пост</th>
            <th scope="col" class="col-2">Комментатор</th>
            <th scope="col" class="col-2">Комментарий</th>
            <th scope="col" class="col-2">Дата</th>
            <th scope="col" class="col-1">Действия</th>
        </tr>
        </thead>
        <tbody class="tablecontents">
        @foreach( $comments as $comment )
            <tr class="align-middle">

                <td class="text-center" >
                    <p class="text-truncate" style="max-width: 120px;" title="{{ $comment->post->title }}">
                        {{ $comment->post->title }}
                    </p>                </td>
                <td class=" text-center ">
                    {{ $comment->user->name }}
                </td>
                <td class="text-center text-truncate" style="max-width: 300px;" >
                    {{ $comment->text }}
                </td>
                <td class="text-center" style="max-width: 300px;" >
                    {{ $comment->created_at }}
                </td>
                <td class=" text-center ">
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
