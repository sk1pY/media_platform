@extends('layouts.app')
@section('content')

    <div class="position-relative mb-3">
        <img style="width: 100%; height: 290px" src="{{Storage::url('categoryImages/'.$category->image)}}" alt="123">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
            <span class="fs-1">{{ $category->name }}</span>
        </div>
    </div>
    @forelse($posts as $post)
        @include('includes/card')
    @empty
        <h3>
            Посты отсутствуют
            <i class="bi bi-emoji-frown"></i>
        </h3>
    @endforelse

    <script> var subAuthors = @json($subAuthors); </script>

    <script src="{{ asset('js/subscribe.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>

@endsection

