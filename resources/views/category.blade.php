@extends('layouts.app')
@section('content')
    <div class="position-relative mb-3">
        <img style="width: 100%; height: 290px" src="{{Storage::url('categoryImages/'.$category->image)}}" alt="123">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
            <span class="fs-1">{{ $category->name }}</span>
        </div>
    </div>

    {{--MAIN CARDS CONTENT--}}
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card border-0 mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-1">
                            <img
                                src="{{$post->user->image? Storage::url('avatarImages/'.$post->user->image):asset('imageAvatar/def.jpg') }}"
                                class="rounded-circle"
                                style="width: 45px; height: 45px;"
                                alt="...">
                        </div>
                        <div class="col pl-0">
                            <div><a class="fw-bold link-dark text-decoration-none"
                                    href="{{ route('home.profile.show',$post-> user -> id) }}">{{ $post -> user->name }}</a>
                            </div>
                            <div>
                                @if($post->category)
                                    <a class="link-secondary active fs-7 text-dark text-decoration-none"
                                       href="{{route('categories.show',$post-> category->id)}}">{{ $post-> category -> name }}
                                    </a>
                                @endif
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>

                            </div>

                        </div>
                        @auth
                            @if($post -> user -> id != Auth::id())
                                <div class="col-auto">
                                    <div class=" sub-button me-3" style="cursor: pointer"
                                         data-author-id="{{ $post->user->id }}">
                                        <button class=" btn btn-secondary ms-3 btnclass "></button>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    <a href="{{ route('posts.show', ['post' => $post ->  id]) }}"
                       class="text-decoration-none text-dark hover-effect">
                        <h5 class="card-title mt-3">{{ $post->title }}</h5>
                        <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                        <div class="card-img-container">
                            <img src="{{ Storage::url('postImages/'.$post->image) }}"
                                 style="width: 100%; height: 290px" class="card-img-top rounded-3"
                                 alt="...">
                        </div>
                    </a>
                    {{--                    LIKE--}}
                    <div class="d-flex justify-content-between align-items-center mt-3 ms-2 ">
                        <div id="post-{{ $post->id }}" class="post d-flex align-items-center">
                            <div style="cursor: pointer" class="like-button me-3"
                                 data-post-id="{{ $post->id }}">
                                <i class="fa-regular fa-heart red-heart {{ in_array($post->id, $likedPostUser) ? ' fa-solid red-heart' : '' }}">
                                    <span class="like-count">{{ $post->likes_count }}</span>

                                </i>
                            </div>
                            {{--                    LIKE--}}
                            <a href="{{ route('posts.show',['post' => $post-> id]) }}" style="cursor: pointer"
                               class="text-decoration-none">
                                <i class="fa-regular fa-comment me-1">
                                    <span class="ms-0">{{ $post->comments_count }}</span>

                                </i>
                            </a>
                            {{--BOOKMARKS--}}
                            <div style="cursor: pointer" class="bookmark-button me-3"
                                 data-bookmark-id="{{ $post->id }}">
                                <i class="ms-3 fa-regular fa-bookmark yellow-bookmark {{
                                                        in_array($post->id,$bookmarkPostUser)? 'fa-solid yellow-bookmark' : '' }}"></i>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
    {{--END MAIN CARDS CONTENT--}}
    <script> var subAuthors = @json($subAuthors); </script>

    <script src="{{ asset('js/subscribe.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>

@endsection

