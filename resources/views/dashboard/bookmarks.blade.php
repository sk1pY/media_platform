@extends('dashboard.layouts.app')
@section('content')
    <h4>Закладки</h4>
    @forelse($bookmarks as $bookmark)
        @include('partials.post_card',['post' => $bookmark->post,'bookmarkFlag' => true])
    @empty
        <h4>Пусто</h4>
    @endforelse

@endsection
