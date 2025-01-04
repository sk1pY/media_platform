@extends('layouts.app')
@section('title', 'Новое')
@section('content')
   @include('includes/card')
    <script> var subAuthors = @json($subAuthors); </script>

    <script src="{{ asset('js/subscribe.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>
@endsection
