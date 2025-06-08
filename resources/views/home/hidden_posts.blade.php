@extends('layouts.home')
@section('home-content')
    <h4>Скрытые посты</h4>
    <div class="col-9">
        @forelse($posts as $post)
            @include('partials.post_card')
        @empty
            <h3>
                Посты отсутсвуют
                <i class="bi bi-emoji-frown"></i>
            </h3>
        @endforelse
        {{-- END MAIN CARDS CONTENT --}}
    </div>
    {{-- MAIN CARDS CONTENT --}}
@endsection
