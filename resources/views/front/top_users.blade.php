@extends('layouts.app')
@section('app-content')

    <div class="bg-white rounded-3 p-3">
        <h6>Топ блогов</h6>
        <hr>
    @foreach($top_users_full as $key => $user)
        <ul class="list-unstyled ms-4">
            <li class="nav-item d-flex align-items-center gap-2">
                <span>{{ $key + 1 }}</span>
                <img
                    src="{{ $user->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                    alt="Аватар" class="rounded" style="object-fit: cover; height: 40px; width: 40px;">
                <div class="d-flex flex-column">
                    <div class="fw-bold"><a href="{{route('users.show',$user)}}">{{ $user->name }}</a></div>
                    <div>{{ $user->sub_count }} подписчиков</div>
                </div>
                {{--                SUBSCRIBE BUTTON--}}
                @can('subscribe_users')
                    @if ($user->id !== auth()->id())
                        <div class="d-flex sub-button me-3 ms-auto" style="height: 35px; cursor: pointer;"
                             data-author-id="{{ $user->id }}"
                             data-url="{{route('subscribe')}}" +>
                            <button
                                class=" btn btn-sm rounded-4  ms-3 {{in_array($user->id, $subAuthors, true)?'btn-outline-secondary':'btn-secondary '}}">
                                {{in_array($user->id, $subAuthors, true)?'Отписаться':'Подписаться'}}</button>
                        </div>
                    @endif
                @endcan
                {{--                SUBSCRIBE BUTTON END--}}
            </li>
        </ul>
    @endforeach
    </div>
@endsection
