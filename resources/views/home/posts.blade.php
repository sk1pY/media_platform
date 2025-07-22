@extends('layouts.home')
@section('home-content')

    @forelse($posts as $post)
        @include('partials.post_card')
    @empty
        <div class="d-flex flex-column align-items-center justify-content-center h-75">
            <span class="text-muted fs-3 ">Посты отсутствуют</span>
            <button type="button" class="btn bg-white rounded-4 text-start w-auto"
                    data-bs-toggle="modal" data-bs-target="#createPost" data-bs-dismiss="modal">
                <span class="text-black">Написать</span>
            </button>
        </div>
    @endforelse

@endsection
