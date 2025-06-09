@extends('layouts.app')
@section('app-content')
{{--    POST CARD--}}
    @include('partials.post_card',['flag_description_substr'=> false])
{{--POST CARD--}}
    {{--        FILTER --}}
    @include('partials.filter')
    {{--        FILTER --}}
    @can('create_comments')
        @auth
            {{-- Comment Form --}}
            <form action="{{ route('posts.comments.store',$post) }}" method="POST">
                @csrf
                <div class="mb-3 mt-3">
                    <textarea class="form-control" id="comment-text" name="text" rows="3"
                              placeholder="Комментарий..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Отправить</button>
            </form>
        @endauth
    @endcan
    {{--         COMMENTS SECTION --}}
    @foreach ($comments as $comment)

        <div id="comment_section" class="card my-2 rounded-4 border-1"
             style="scroll-margin-top: 250px;">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <img
                            src="{{ $comment->user->image ? Storage::url('avatarImages/' . $comment->user->image) : asset('default_images/defaultAvatar.jpg') }}"
                            class="rounded-circle" style="width: 40px; height: 40px;" alt="avatar">
                        <div class="ms-2">
                            <a href="{{ route('users.show', $comment->user) }}"
                               class="fw-bold link-dark text-decoration-none">
                                {{ $comment->user->name }}
                            </a>
                            <div class="text-muted small">
                                {{$comment->updated_at !== $comment->created_at?'Изменено':''}}

                                {{ $comment->updated_at->diffForHumans() }}
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex align-items-center ">

                            @can('update',$comment)
                                <button type="button" class="btn " data-bs-toggle="modal"
                                        data-bs-target="#updateComment-{{$comment->id}}">
                                    <i class="bi bi-pencil-square"></i></button>
                            @endcan
                            @can('delete', $comment)
                                <form action="{{ route('posts.comments.destroy', [$post,$comment]) }}" method="POST"
                                      class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-link text-danger p-0"
                                            title="Удалить комментарий"
                                            onclick="return confirm('Точно удалить?')">
                                        <i class="bi bi-x fs-2"></i>
                                    </button>
                                </form>
                            @endcan

                        </div>

                    </div>
                </div>
                <div class=" d-flex flex-column ">
                    <div class="mt-2 me-3 ms-5">{{ $comment->text }}</div>
                    <div class="d-flex m-2 fs-6 comment ms-5">
                        <div class="like-comment"
                             data-comment-id="{{ $comment->id }}"
                             data-url="{{route('posts.comments.like')}}">
                            <i class="bi text-danger {{in_array($comment->id, $likeCommentUser, true)?'bi-heart-fill':'bi-heart'}}"
                               data-comment-id="{{ $comment->id }}"
                               style="cursor: pointer">
                            </i>
                            <span class="like-count">{{ $comment->like }}</span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal  UPD comment-->
        <div class="modal fade" id="updateComment-{{$comment->id}}" tabindex="-1"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Комментарий</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="myForm" action="{{route('posts.comments.update',[$post,$comment])}}"
                              method="post">
                            @csrf
                            @method('put')
                            <textarea class="form-control" rows="4" cols="50" type="text"
                                      name="text">{{ old('text',$comment->text) }}</textarea>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть
                        </button>
                        <button form="myForm" type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
    {{ $comments->links('pagination::bootstrap-5') }}

@endsection
