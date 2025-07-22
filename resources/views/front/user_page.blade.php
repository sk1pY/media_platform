@extends('layouts.app')
@section('app-content')
    <input type="hidden" id="user-id" value="{{$user->id }}">

    <section class="h-100 gradient-custom-2">
        <div class="container">
            <div class="card text-white border-0 rounded-4 overflow-hidden shadow-lg mb-4">
                <img src="{{ $user->image_cover ? Storage::url('profileCoverImages/' . $user->image_cover) : asset('default_images/defaultImage.png') }}"
                     class="card-img" alt="..." style="object-fit: cover; height: 250px;">

                <div class="card-img-overlay d-flex flex-column justify-content-end p-4"
                     style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1));">

                    <div class="d-flex align-items-center">
                        <img src="{{ $user->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                             alt="Иконка {{ $user->name }}" class="img-fluid rounded-circle me-3"
                             style="width: 70px; height: 70px; object-fit: cover; border: 3px solid white;">

                        <div>
                            <h4 class="card-title mb-0">{{ $user->name }}</h4>
                        </div>
                        <div class="ms-auto">
                        </div>
                    </div>
                </div>
            </div>
            <div >
                <span>@ {{ $user->name }} </span>
                <span>{{$countSubAuthors}} подписчика </span>

            </div>

            <div class="text-black mt-3">
                {{--        FILTER --}}
                @include('partials.filter')
                {{--        FILTER --}}
                <div class=" text-body">
                    <div id="search-cards">
                        {{-- MAIN CARDS CONTENT --}}
                        @foreach ($posts as $post)
                            @include('partials.post_card',['flag_description_substr' => true])
                        @endforeach
                        {{-- END MAIN CARDS CONTENT --}}
                    </div>
                </div>

            </div>
        </div>

    </section>
@endsection
