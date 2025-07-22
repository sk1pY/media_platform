@extends('layouts.app')
@section('app-content')

    <input type="hidden" id="category-slug" value="{{$category->slug }}">

    <div class="card text-white border-0 rounded-4 overflow-hidden shadow-lg mb-4">
        <img src="{{ $category->image ? Storage::url('categoryImages/' . $category->image) : asset('default_images/defaultImage.png') }}"
             class="card-img" alt="Изображение категории {{ $category->name }}" style="object-fit: cover; height: 250px;">

        <div class="card-img-overlay d-flex flex-column justify-content-end p-4"
             style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1));">

            <div class="d-flex align-items-center">
                <img src="{{ $category->image ? Storage::url('categoryImages/' . $category->image) : asset('default_images/defaultAvatar.jpg') }}"
                     alt="Иконка {{ $category->image }}" class="img-fluid rounded-circle me-3"
                     style="width: 70px; height: 70px; object-fit: cover; border: 3px solid white;">

                <div>
                    <h4 class="card-title mb-0">{{ $category->name }}</h4>
                    <p class="card-text">{{ $category->description }}</p>
                </div>
            </div>
        </div>
    </div>


    {{-- FILTER --}}
    @include('partials.filter')
    {{-- END FILTER --}}
    <div  id="search-cards">
        @forelse($posts as $post)
            @include('partials.post_card')
        @empty
            <div class="col">
                <h3>Ничего не найдено</h3>
            </div>
        @endforelse
    </div>
@endsection

