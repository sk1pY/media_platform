@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row">
           <div class="col-3">
                <div class="sticky-top mt-4" style="top: 84px;">
                    @include('partials.profile_sidebar')
                </div>
            </div>

            <div class="col mt-4">
                @yield('home-content')
            </div>
        </div>
    </div>
@endsection
