@extends('dashboard.layouts.app')
@section('content')
    @include('partials.error_alert')
    @foreach($posts as $post)

            @include('partials.post_card',['profileFlag' => true])

    @endforeach

    {{-- MODAL EDIT PROFILE  --}}
    <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profile.update',$user) }}" enctype="multipart/form-data"
                          method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Имя</label>
                            <input name="name" type="text" class="form-control" id="exampleFormControlInput1"
                                   value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Почта</label>
                            <input name="email" type="email" class="form-control" id="exampleFormControlInput2"
                                   value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput3" class="form-label">Фото профиля</label>
                            <input name="image" type="file" class="form-control" id="exampleFormControlInput3">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput3" class="form-label">Фото обложки профиля</label>
                            <input name="image_cover" type="file" class="form-control" id="exampleFormControlInput3">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть
                        </button>
                        <input type="submit" value="Обновить" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL EDIT PROFILE  --}}
    <!-- MODAL UPDATE POST-->
    @foreach ($posts as $editpost)

        <div class="modal fade" id="update_post{{ $editpost->id }}" tabindex="-1"
             aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.update', $editpost) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="postTitle" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $editpost->title }}">
                            </div>
                            <div class="mb-3">
                                <label for="postDescription" class="form-label">Description</label>
                                <input type="text" name="description" class="form-control"
                                       value="{{ $editpost->description }}">
                            </div>
                            <div class="mb-3">
                                <label for="postImage" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control"
                                       id="postImage">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                            </button>
                            <input type="submit" class="btn btn-warning" value="Update">
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <!-- END MODAL UPDATE POST-->

@endsection
