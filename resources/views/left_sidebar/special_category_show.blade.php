@extends('layouts.app')
@section('content')

    <input type="hidden" id="special_category_slug" value="{{$slug}}">

    <h4 class="d-flex justify-content-center">{{$slug}}</h4>

    @include('partials.filter')

    <div class="" id="search-cards">
        @forelse($posts as $post)
            @include('partials.post_card')
        @empty
            <div class="col">
                <h3>Ничего не найдено</h3>
            </div>
        @endforelse
    </div>
@endsection
