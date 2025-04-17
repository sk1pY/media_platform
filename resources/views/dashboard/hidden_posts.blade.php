@extends('dashboard.layouts.app')
@section('content')
    <h4>Скрытые посты</h4>
    {{-- MAIN CARDS CONTENT --}}
    @forelse($posts as $post)
        @include('partials.post_card')
    @empty
        <h3>
            Посты отсутсвуют
            <i class="bi bi-emoji-frown"></i>
        </h3>
    @endforelse
    {{-- END MAIN CARDS CONTENT --}}

@endsection
