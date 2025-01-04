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
    {{--FILTER--}}
    <div class="mb-2">
        <form action="{{ route('index') }}" id="filterForm" method="get">

            <select class="form-select w-25 text-decoration-none" id="rating" name="filter" form="filterForm"
                    onchange="this.form.submit()">

                <option value="">Выберите фильтр</option>
                <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }} >Самые новые
                </option>
                <option value="old" {{ request('filter') === 'old' ? 'selected' : '' }}> Самые старые
                </option>
{{--                <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>Популярные--}}
                {{--                </option>--}}
            </select>
        </form>
    </div>
    {{--FILTER--}}

    @include('includes/card')

{{--    SCRIPTS--}}
    <script src="{{ asset('js/like.js') }}"></script>
    <script src="{{ asset('js/bookmark.js') }}"></script>
    <script> var subAuthors = @json($subAuthors); </script>
    <script src="{{ asset('js/subscribe.js') }}"></script>

@endsection
