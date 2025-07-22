@extends('layouts.home')
@section('home-content')
    <div class="row">
        @forelse ($authors as $author)
            <div id="subscribe-card-user-{{$author->id}}" style="width: 170px;" class="p-1">
                <div class="card h-100 d-flex flex-column">
                    <div class="d-flex justify-content-center align-items-center">
                        <img
                            src="{{ $author->image ? Storage::url('avatarImages/' . $author->image) : asset('default_images/defaultAvatar.jpg') }}"
                            class="img-fluid w-75"
                            alt="...">
                    </div>
                    <div class="card-body d-flex flex-column text-center flex-grow-1">
                        <h5 class="card-title fs-6 "><a class="text-decoration-none text-dark"
                                                        href="{{route('users.show',$author)}}">{{ $author->name }}</a>
                        </h5>
                        @if ($author->id !== auth()->id())
                            <div class="mt-auto sub-button"
                                 data-author-id="{{ $author->id }}"
                                 data-url="{{route('subscribe')}}">
                                <button
                                    class="btn btn-secondary w-100">
                                    {{ in_array($author->id, $subAuthors, true) ? 'Отписаться' : 'Подписаться' }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex flex-column align-items-center justify-content-center h-75">
                <span class="text-muted fs-3 ">Пидписки отсутствуют</span>
            </div>
        @endforelse
    </div>

@endsection

