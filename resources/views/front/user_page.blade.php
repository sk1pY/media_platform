@extends('layouts.app')
@section('app-content')
    <input type="hidden" id="user-id" value="{{$user->id }}">

    <section class="h-100 gradient-custom-2 ">
        <div class="container ">
            <div class="card">
                <div class="border-0 text-white d-flex flex-column z-1 overflow-hidden"
                     style=" height: 250px;">
                    <img class=" border-0 rounded"
                         src="{{ $user->image_cover ? Storage::url('profileCoverImages/' . $user->image_cover) : asset('default_images/defaultImage.png') }}"
                         style="height: 250px" alt="123">
                </div>

            </div>
            <div class="p-4 text-black bg-body-tertiary">
                <div class="d-flex justify-content-between text-center">
                    <div class="d-flex justify-content-center align-items-center">
                        <img
                            src="{{ $user->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                            alt="111" class=" border rounded-4"
                            style="width: 90px; height: 90px;">
                        <h5 class="align-center ms-2">{{ $user->name }}</h5>
                    </div>
                    <div class="d-flex">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-1 h5">{{ count($posts) }}</p>
                            </div>
                            <div class="ms-1">
                                <p class="small text-muted mb-0 ">Публикации</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center ms-2">
                            <div>
                                <p class="mb-1 h5 mb-0">{{ $countSubAuthors }}</p>
                            </div>
                            <div class="ms-1">
                                <p class="small text-muted mb-0">Подписчиков</p>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-body  text-black mt-3">
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
