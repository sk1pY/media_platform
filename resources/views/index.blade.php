@extends('layouts.app')
@section('content')
    {{-- FILTER --}}
    @include('partials.filter')
    {{-- END FILTER --}}
    {{--    POSTS--}}
{{--    <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>--}}






    <div id="search-cards">
        @forelse($posts as $post)
            @include('partials.post_card')
        @empty
            <h3>Ничего не найдено</h3>
        @endforelse
    </div>
    {{--    END POSTS--}}



@endsection
