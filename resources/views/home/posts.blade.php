@extends('layouts.home')
@section('home-content')

        @foreach($posts as $post)
            @include('partials.post_card',['flag_description_substr'=> true])
        @endforeach

@endsection
