<div class="bg-white rounded-3 p-3">
    <ul class="nav flex-column ">
        <span class=" fw-bold">Топ блогов</span>
        @foreach($top_users as $key => $user)
            <ul class="list-unstyled m-2 ">
                <li class="nav-item d-flex align-items-center gap-2">
                    <span>{{ $key + 1 }}</span>
                    <img
                        src="{{ $user->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                        alt="Аватар" class="rounded-circle" style="object-fit: cover; height: 40px; width: 40px;">
                    <div class="d-flex flex-column">
                        <div class="fw-bold"><a href="{{route('users.show',$user)}}">{{ $user->name }}</a></div>
                        <div>{{ $user->sub_count }} подписчиков</div>
                    </div>
                </li>
            </ul>
        @endforeach
        <a href="{{route('users.topUsers')}}" class="link-opacity-75-hover text-muted" >Посмотреть весь топ</a>
    </ul>
</div>

