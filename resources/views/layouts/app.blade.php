@extends('layouts.base')

@section('content')

    <div class="row">
        <div class="col-3 d-none d-md-block">
            <div class="sticky-top mt-4" style="top: 84px;">

            @include('partials.categories_sidebar')
            </div>
        </div>
        <div class="col mt-4">
            @yield('app-content')
        </div>
        <div class="col-3">
            <div class="mt-4" >
{{--            @include('partials.profile_sidebar')--}}
            @include('partials.top_blogs')
            @include('partials.top_comments')
            </div>
        </div>
    </div>
@endsection
