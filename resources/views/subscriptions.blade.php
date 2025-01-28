@extends('layouts.app')
@section('content')
    <h1>Мои подписки</h1>
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-3">
        @foreach($authors as $author)
            <div class="col">
                <div class="card h-100">
                    <div class="d-flex justify-content-center align-items-center" style="height: 100px;">
                        <img src="{{ Storage::url('avatarImages/'.$author->image) }}"
                             class="card-img-top img-fluid"
                             alt="..."
                             style="max-width: 80px;">
                    </div>
                    <div class="card-body p-2">
                        <h5 class="card-title mb-1">{{ $author->name }}</h5>
                        @if($author->id != Auth::id())
                            <div class="d-flex sub-button "
                                 style="height: 30px; cursor: pointer;"
                                 data-author-id="{{ $author->id }}">
                                <button class="btn btn-secondary btn-sm ms-2 "></button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{--    {{ $comments->links('pagination::bootstrap-5') }}--}}
    <script> var subAuthors = @json($subAuthors); </script>

    <script src="{{ asset('js/subscribe.js') }}"></script>

@endsection
