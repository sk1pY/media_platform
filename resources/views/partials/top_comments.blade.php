<div class="bg-white rounded-3 p-3 mt-3">
    <ul class="nav flex-column ">
        <span class=" fw-bold">Популярные комментарии</span>
        @foreach($top_comments as $value => $comment)
            <ul class="list-unstyled m-2 ">
                <li class="nav-item d-flex align-items-center gap-2">
                    <span>{{ $value + 1}}</span>
                    <img
                        src="{{ $comment->user->image ? Storage::url('avatarImages/' . $comment->user->image) : asset('default_images/defaultAvatar.jpg') }}"
                        alt="Аватар" class="rounded-circle" style="object-fit: cover; height: 40px; width: 40px;">
                    <div class="d-flex flex-column">
                        <div class="fw-bold"><a href="{{route('users.show',$comment->user)}}">{{ $comment->user->name }}</a>
                        </div>
                        <div><a href="{{route('posts.show',$comment->post)}}#comment-{{$comment->id}}">{{substr($comment->text,0,27)}}...</a></div>
                        <div>
                            <i class="bi bi-heart-fill text-danger"></i>
                            {{$comment->likes}}</div>

                    </div>
                </li>
            </ul>
        @endforeach
    </ul>
</div>

