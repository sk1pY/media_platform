{{-- CATEGORIES --}}
<div class="sticky-top" style="top: 80px; max-height: calc(100vh - 70px); overflow-y: auto;">
    <ul class="nav flex-column">
        <a style="font-size: 1rem;" class=" rounded-pill  nav-link active  text-dark" aria-current="page"
           href="{{ route('specialCategories.show','popular') }}">
            <i class="fa-solid fa-fire p-0" style="width: 20px; height: 20px"></i>
            <span class="ms-1">Популярное</span>
        </a>
        <a style="font-size: 1rem;" class="rounded-pill nav-link active text-dark" aria-current="page"
           href="{{ route('specialCategories.show','fresh') }}">
            <i class="fa-regular fa-clock" style="width: 20px; height: 20px"></i>
            <span class="ms-1">Свежее за 24ч</span>
        </a>
        <a style="font-size: 1rem;" class="rounded-pill nav-link active text-dark" aria-current="page"
           href="{{ route('specialCategories.show','myFeed') }}">
            <i class="fa-regular fa-clipboard" style="width: 20px; height: 20px"></i>
            <span class="ms-1">Моя лента</span>
        </a>
        <h1 class="fs-6 mt-3 ms-3" style="color: grey;">Темы</h1>

        @if (count($categories) > 0)
            @foreach ($categories as $category)
                <li class="rounded-pill nav-link d-flex align-items-center p-1" >
                    <img
                        src="{{ $category->image?Storage::url('categoryImages/' . $category->image):asset('default_images/defaultImage.png') }}"
                        alt="..."
                        class=" rounded-circle" style="width:25px;height: 25px">

                    <a style="font-size: 1.1rem;"
                       class="ms-2 link-secondary active text fw-normal text-dark text-decoration-none"
                       href="{{ route('categories.show', $category) }}">{{ $category->name }}</a>
                </li>

            @endforeach
        @endif
    </ul>

</div>
{{-- END CATEGORIES --}}
