@extends('layouts.home')
@section('home-content')
    <h4>Закладки</h4>
    <div class="col-9">

        @forelse($bookmarks as $bookmark)
            @include('partials.post_card',['post' => $bookmark->post])
        @empty
            <h4>Пусто</h4>
        @endforelse
    </div>
@endsection
