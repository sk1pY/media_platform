@extends('layouts.home')
@section('home-content')

        @foreach($posts as $post)
            @include('partials.post_card')
        @endforeach

@endsection
