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
            {{-- FILTER --}}
            <div class="mb-2">
                <form action="{{ route('index') }}" id="filterForm" method="get">
                    <select style="width:200px" class="form-select  text-decoration-none" id="rating" name="filter"
                            form="filterForm"
                            onchange="this.form.submit()">

                        <option value="">Выберите фильтр</option>
                        <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }}>Сначала новые
                        </option>
                        <option value="old" {{ request('filter') === 'old' ? 'selected' : '' }}> Сначала старые
                        </option>
                        <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>Самые популярные
                        </option>
                    </select>
                </form>
            </div>
            {{-- END FILTER --}}
            {{--    POSTS--}}
            @forelse($posts as $post)
                @include('partials/post_card')
            @empty
                <h3>
                    Посты отсутствуют
                    <i class="bi bi-emoji-frown"></i>
                </h3>
            @endforelse
            {{--    END POSTS--}}

    {{--    SCRIPTS --}}
    <script>
        var likePostUrl = '{{ route('like_post') }}';
    </script>
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script>
        var subAuthors = @json($subAuthors);
    </script>
    <script src="{{ asset('js/subscribe.js') }}"></script>

@endsection
