{{-- CATEGORIES --}}
<style>
    .category-link:hover {
        background-color: white;
    }

    .scroll-wrapper {
        position: sticky;
        top: 70px;
        max-height: calc(100vh - 100px);
        overflow: hidden;
        z-index: 10;
    }

    .scroll-inner {
        max-height: inherit;
        overflow-y: hidden;
    }

    .scroll-wrapper:hover .scroll-inner {
        overflow-y: auto;
    }

    .scroll-inner::-webkit-scrollbar {
        width: 5px;
    }
    .scroll-inner::-webkit-scrollbar-thumb {
        background-color: lightgrey;
        border-radius: 4px;
    }
    .scroll-inner::-webkit-scrollbar-track {
        background-color: transparent;
    }

</style>
<div class="scroll-wrapper sticky-top">
    <div class="scroll-inner">
            <ul class="nav flex-column ">
                <a style="font-size: 1.2rem;" class="rounded-pill nav-link active  text-dark" aria-current="page"
                   href="{{ route('specialCategories.show','popular') }}">
                    <i class="bi bi-fire" style="width: 20px; height: 20px"></i>
                    <span class="ms-1">Популярное</span>
                </a>
                <a style="font-size: 1.2rem;" class="rounded-pill nav-link active text-dark" aria-current="page"
                   href="{{ route('specialCategories.show','fresh') }}">
                    <i class="bi bi-clock" style="width: 20px; height: 20px"></i>
                    <span class="ms-1">Свежее за 24ч</span>
                </a>
                @auth
                    <a style="font-size: 1.2rem;" class="rounded-pill nav-link active text-dark" aria-current="page"
                       href="{{ route('specialCategories.show','myFeed') }}">
                        <i class="bi bi-clipboard" style="width: 20px; height: 20px"></i>
                        <span class="ms-1">Моя лента</span>
                    </a>
                @endauth
                <h1 class="fs-6 mt-3 ms-3" style="color: grey;">Темы</h1>

                @if (count($categories) > 0)
                    @foreach ($categories as $category)
                        <li class="nav-item">
                            <a href="{{ route('categories.show', $category) }}"
                               class="rounded-pill p-2 category-link d-flex align-items-center text-decoration-none text-dark w-100 h-100"
                               style="font-size: 1.1rem;">
                                <img src="{{ $category->image
                      ? Storage::url('categoryImages/' . $category->image)
                      : asset('default_images/defaultImage.png') }}"
                                     alt="..."
                                     class="rounded-circle me-2"
                                     style="width: 2em; height: 2em">
                                {{ $category->name }}
                            </a>
                        </li>

                    @endforeach
                @endif
            </ul>
    </div>
</div>
{{-- END CATEGORIES --}}
