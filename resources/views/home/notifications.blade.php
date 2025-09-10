@extends('layouts.home')
@section('home-content')
    @foreach($notifications as $notification)
            <div class="notification d-flex flex-wrap align-items-center">
                <span class="me-2">{{ $notification->data['user_name'] ?? '' }}</span>
                <span class="me-2">{{ $notification->data['message'] ?? '' }}</span>
                @if(isset($notification->data['post_id']))
                    <a href="{{ route('posts.show', $notification->data['post_title']) }}">
                        {{ $notification->data['post_title'] ?? 'Пост' }}
                    </a>
                @endif
                <span class="ms-2"> {{ $notification->created_at->diffForHumans() }}</span>
            </div>

    @endforeach
@endsection
