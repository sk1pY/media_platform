@extends('layouts.app')
@section('app-content')
    {{-- FILTER --}}
    @include('partials.filter')
    {{-- END FILTER --}}
    {{--    POSTS--}}
    <div id="search-cards">
        @forelse($posts as $post)
            @include('partials.post_card',['flag_description_substr' => true])
        @empty
            <h3>Ничего не найдено</h3>
        @endforelse
    </div>
    {{--    END POSTS--}}
@endsection
