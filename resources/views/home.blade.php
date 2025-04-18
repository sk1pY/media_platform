@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="h-100 gradient-custom-2">
        <div class="container h-100 " style="width: 1000px">
            <div class="row d-flex ">
                <div class="colw col-lg-9 col-xl-8">
                    <div class="card">
                        <div class="rounded-top text-white d-flex flex-column z-1 overflow-hidden"
                             style="background-color: #444444; height: 250px;">
                            <img class="object-fit-fill border rounded"
                                 src="{{ $user->image_cover ? Storage::url('profileСoverImages/' . $user->image_cover) : asset('default_images/defaultImage.png') }}"
                                 style="height: 250px" alt="123">
                        </div>
                    </div>
                    <div class="p-4 text-black bg-body-tertiary">
                        <div class="d-flex justify-content-between align-items-center text-center py-1 text-body">
                            <div class="d-flex flex-column ">
                                <div class="d-flex flex-row justify-content-center align-items-center">
                                    <img
                                        src="{{ $user->image ? Storage::url('avatarImages/' . $user->image) : asset('default_images/defaultAvatar.jpg') }}"
                                        alt="111" class="object-fit-fill border rounded-circle "
                                        style="width: 90px; height: 90px;">
                                    <h5 class="mb-0 ms-3">{{ $user->name }}</h5>
                                </div>
                                <div class="d-flex align-items-center mt-3 ">



                                </div>
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
                    <div class="card-body p-4 text-black">
                        <div class=" text-body">
                            {{-- MAIN CARDS CONTENT --}}
                            @foreach ($posts as $post)
                                @include('partials.post_card',['homeFlag' => true])
                            @endforeach
                            {{-- END MAIN CARDS CONTENT --}}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
