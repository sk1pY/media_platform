@extends('dashboard.layouts.app')
@section('content')
    @foreach($posts as $post)
        @include('partials.post_card')
    @endforeach
@endsection
