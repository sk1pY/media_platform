@extends('layouts.app')
@section('content')

    <div class="position-relative mb-3">
        <img style="width: 100%; height: 290px" src="{{Storage::url('categoryImages/'.$category->image)}}" alt="123">
        <div class="position-absolute top-50 start-50 translate-middle text-white fw-bold">
            <span class="fs-1">{{ $category->name }}</span>
        </div>
    </div>
    @include('includes/card')

    <script> var subAuthors = @json($subAuthors); </script>

    <script src="{{ asset('js/subscribe.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>

@endsection

