@extends('layouts.app')
@section('content')

    <div class="position-relative mb-3">
        <img style="width: 100%; height: 290px" src="{{Storage::url('categoryImages/'.$category->image)}}" alt="123">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
            <span class="fs-1">{{ $category->name }}</span>
        </div>
    </div>
    @forelse($posts as $post)
        @include('partials.post_card')
    @empty
        <h3>
            Посты отсутствуют
            <i class="bi bi-emoji-frown"></i>
        </h3>
    @endforelse
@endsection

