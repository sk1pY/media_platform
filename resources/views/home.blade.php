@extends('layouts.app')
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
    <section class="h-100 gradient-custom-2">
        <div class="container h-100 " style="width: 1000px">
            <div class="row d-flex ">
                <div class="colw col-lg-9 col-xl-8">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-column z-1 overflow-hidden"
                             style="background-color: #444444; height: 250px;">
                            <img class=""
                                 src="{{ $user->image_cover ? Storage::url('profile_cover_images/' . $user->image_cover) : asset('default_images/defaultImage.png') }}"
                                 style="height: 250px" alt="123">
                        </div>
                    </div>
                    <div class="p-4 text-black bg-body-tertiary">
                        <div class="d-flex justify-content-between align-items-center text-center py-1 text-body">
                            <div class="d-flex flex-column ">
                                <div class="d-flex flex-row justify-content-center align-items-center">
                                    <img
                                        src="{{ $user->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                                        alt="111" class="rounded-circle border-0 img-thumbnail"
                                        style="width: 90px; height: 90px;">
                                    <h5 class="mb-0 ms-3">{{ $user->name }}</h5>
                                </div>
                                <div class="d-flex align-items-center mt-3 ">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-1 h5">{{ count($posts) }}</p>
                                        </div>
                                        <div class="ms-1">
                                            <p class="small text-muted mb-0 ">Публикации</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center ms-2">
                                        <div>
                                            <p class="mb-1 h5 mb-0">{{ $countSubAuthors }}</p>
                                        </div>
                                        <div class="ms-1">
                                            <p class="small text-muted mb-0">Подписчиков</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div>
                                @auth
                                    @if (Auth::user()->id == $user->id)
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editProfile"
                                                data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-outline-secondary  "
                                                data-mdb-ripple-color="red" style="z-index: 1;">
                                            Изменить профиль
                                        </button>
                                    @else
                                    @endif
                                @endauth
                            </div>

                        </div>

                    </div>
                    <div class="card-body p-4 text-black">
                        <div class=" text-body">
                            {{-- MAIN CARDS CONTENT --}}
                            @foreach ($posts as $post)
                                @include('includes.card',['homeFlag' => true])
                            @endforeach
                            {{-- END MAIN CARDS CONTENT --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- MODAL EDIT PROFILE  --}}
    <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.update',$user) }}" enctype="multipart/form-data"
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
