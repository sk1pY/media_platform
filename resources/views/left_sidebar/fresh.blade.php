@extends('layouts.app')
@section('title', 'Новое')
@section('content')
    <h4 class="d-flex justify-content-center">Свежее за 24ч</h4>
@forelse($posts as $post)
        @include('partials.post_card')
    @empty
        <h3>
            Посты отсутствуют
            <i class="bi bi-emoji-frown"></i>
        </h3>
    @endforelse
@endsection
