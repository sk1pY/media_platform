@extends('layouts.app')
@section('app-content')
    <input type="hidden" id="special_category_slug" value="{{$slug}}">
    @include('partials.filter')

    <div id="search-cards">
        @forelse($posts as $post)
            @include('partials.post_card',['flag_description_substr' => true])
        @empty
                Ничего не найдено
        @endforelse
    </div>
@endsection
