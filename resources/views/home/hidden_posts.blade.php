@extends('layouts.home')
@section('home-content')
    <h4>Скрытые посты</h4>
    <div class="col-9">
        @forelse($posts as $post)
            @include('partials.post_card')
        @empty
            <h4>Пусто</h4>
        @endforelse
        {{-- END MAIN CARDS CONTENT --}}
    </div>
    {{-- MAIN CARDS CONTENT --}}
@endsection
