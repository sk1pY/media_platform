@extends('layouts.app')
@section('content')

    <input type="hidden" id="category-slug" value="{{$category->slug }}">
    <div class="position-relative mb-3">
        <img style="width: 100%; height: 290px" src="{{Storage::url('categoryImages/'.$category->image)}}" alt="123">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
            <span class="fs-1">{{ $category->name }}</span>
        </div>
    </div>
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

