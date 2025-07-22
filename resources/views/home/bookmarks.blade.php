@extends('layouts.home')
@section('home-content')
        @forelse($bookmarks as $bookmark)
            @include('partials.post_card',['post' => $bookmark->post])
        @empty
            <div class="d-flex flex-column align-items-center justify-content-center h-75">
                <span class="text-muted fs-3 ">Закладки отсутствуют</span>

            </div>
    @endforelse

@endsection
