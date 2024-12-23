@extends('layouts.app')
@section('content')
    <section class="h-100 gradient-custom-2">
        <div class="container  h-100 " style="width: 1000px">
            <div class="row d-flex ">
                <div class="col col-lg-9 col-xl-8">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-row"
                             style="background-color: #444444; height:200px;">
                            <div class="ms-4 mt-3 d-flex flex-column" style="width: 150px;">
                                <img src="{{$user->image? Storage::url('avatarImages/'.$user->image):asset('imageAvatar/def.jpg') }}"
                                     alt="111"
                                     class="rounded-circle border-0 img-thumbnail mt-5 mb-2"
                                     style=" z-index: 1">
                            </div>

                            <div class="ms-3" style="margin-top: 130px;">
                                <h5>{{ $user->name }}</h5>
                            </div>
                        </div>
                        <div class="p-4 text-black bg-body-tertiary">
                            <div class="d-flex justify-content-between align-items-center text-center py-1 text-body">
                                <div>
                                    @auth
                                    @if (Auth::user()->id == $user->id)
                                        <button type="button" data-bs-toggle="modal"
                                                data-bs-target="#editProfile" data-mdb-button-init data-mdb-ripple-init
                                                class="btn btn-outline-warning text-body " data-mdb-ripple-color="red"
                                                style="z-index: 1;">
                                            Edit profile
                                        </button>
                                    @else
                                        <div class="sub-button me-3" style="cursor: pointer"
                                             data-author-id="{{ $user->id }}">
                                            <button class=" ms-3 btnclass btn btn-primary {{
                                                        in_array($user->id,$subAuthors)? 'buttonsub' : '' }}">
                                                {{
                                                            in_array($user->id,$subAuthors)? 'Отписаться' : 'Подписаться' }}
                                            </button>
                                        </div>
                                    @endif
                                    @endauth
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <p class="mb-1 h5">{{ count($posts) }}</p>
                                        <p class="small text-muted mb-0">Постов</p>
                                    </div>
                                    <div>
                                        <p class="mb-1 h5">{{ $countSubAuthors  }}</p>
                                        <p class="small text-muted mb-0">Подписчики</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-body p-4 text-black">
                            <div class=" text-body">
                                {{--MAIN CARDS CONTENT--}}
                                @if(count($posts) > 0)
                                    @foreach($posts as $post)
                                        <div class="card border-0 mb-4">
                                            <div class="card-body">
                                                <div class="row align-items-center">
                                                    <div class="col pl-0">
                                                        <div class="row align-items-center">
                                                            <div class="col-1">
                                                                <img
                                                                    src="{{$post->user->image? Storage::url('avatarImages/'.$post->user->image):asset('imageAvatar/def.jpg') }}"
                                                                    class="rounded-circle"
                                                                    style="width: 45px; height: 45px;"
                                                                    alt="...">
                                                            </div>
                                                            <div class="col pl-0">
                                                                <div>{{ $post -> user->name }}</div>
                                                                <div>
                                                                    @if($post->category)
                                                                        <a class="link-secondary active fs-7 text-dark text-decoration-none"
                                                                           href="{{ route('categories.show',$post->category->id ) }}">{{ $post-> category -> name }}
                                                                        </a>
                                                                    @endif
                                                                        <?php

                                                                        $date_string = strval($post->created_at);
                                                                        $date = new DateTime($date_string);
                                                                        $current_date = new DateTime();

                                                                        // Сравниваем дату с текущей датой
                                                                        if ($date->format('Y-m-d') == $current_date->format('Y-m-d')) {
                                                                            echo $date->format('H:i');
                                                                        } elseif ($date->format('Y-m-d') == $current_date->modify('-1 day')->format('Y-m-d')) {
                                                                            echo "Yesterday";
                                                                        } else {
                                                                            echo $date->format('d F');
                                                                        }

                                                                        ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a href="{{ route('posts.show', ['post' => $post ->  id]) }}"
                                                   class="text-decoration-none text-dark hover-effect">
                                                    <h5 class="card-title mt-3">{{ $post->title }}</h5>
                                                    <div class="card-img-container">
                                                        <img

                                                            src="{{ Storage::url('postImages/'.$post->image) }}"
                                                            style="width: 100%; height: 290px;"
                                                            class="card-img-top rounded-3"
                                                            alt="...">
                                                    </div>
                                                </a>
                                                @auth()
                                                @if ( Auth::user()->id == $user->id)
                                                    <div class="card-footer">
                                                        <form action="{{ route('home.delete.task', $post->id) }}"
                                                              method="POST"
                                                              class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input class="btn btn-outline-danger" type="submit"
                                                                   value="Удалить">
                                                        </form>
                                                        <button type="button" class="btn btn-outline-warning"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editPostModal{{ $post->id }}">
                                                            Изменить
                                                        </button>
                                                    </div>
                                                @endif
                                                @endauth
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                {{--END MAIN CARDS CONTENT--}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- MODAL EDIT PROFILE WINDOW --}}
    <div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('home.update.profile', $user->id) }}"
                          enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input name="name" type="text" class="form-control"
                                   id="exampleFormControlInput1" value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput2" class="form-label">Email</label>
                            <input name="email" type="email" class="form-control"
                                   id="exampleFormControlInput2" value="{{ $user->email }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput3" class="form-label">Image</label>
                            <input name="image" type="file" class="form-control"
                                   id="exampleFormControlInput3">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                        </button>
                        <input type="submit" value="Update" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL EDIT PROFILE WINDOW --}}
    <!-- MODAL UPDATE POST-->
    @foreach($posts as $post)
        <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Post</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('home.update.task', $post->id) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label for="postTitle{{ $post->id }}" class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                       id="postTitle{{ $post->id }}" value="{{ $post->title }}">
                            </div>
                            <div class="mb-3">
                                <label for="postDescription{{ $post->id }}"
                                       class="form-label">Description</label>
                                <input type="text" name="description" class="form-control"
                                       id="postDescription{{ $post->id }}" value="{{ $post->description }}">
                            </div>
                            <div class="mb-3">
                                <label for="postImage{{ $post->id }}" class="form-label">Image</label>
                                <input type="file" name="image" class="form-control"
                                       id="postImage{{ $post->id }}">
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


<script>

    $(document).ready(function () {
        $('.sub-button').on('click', function () {
            var subId = $(this).data('author-id');
            var subButton = $(this).find('.btnclass');

            $.ajax({
                url: '/subscribe',
                method: 'POST',
                data: {
                    sub_id: subId
                },
                success: function (response) {
                    if (response.success) {
                        if (response.sub) {
                            subButton.text('Отписаться');
                            subButton.addClass('buttonsub');


                        } else {
                            subButton.text('Подписаться');
                            subButton.removeClass('buttonsub');
                        }
                    } else {
                        $('#message').text(response.message).css('color', 'red');
                    }

                },
                error: function (xhr, status, error) {
                    // Обработка ошибки
                    console.error('Произошла ошибка при добавлении/удалении закладки');

                    // Дополнительные действия, если нужно
                }
            });
        });
    });

</script>
@endsection
