{{-- CATEGORIES --}}
<style>
    .category-link:hover {
        background-color: white;
    }

    .scroll-wrapper {
        position: sticky;
        top: 0;
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
    .nav-tabs .nav-link.active {
        background-color: #0a53be !important;
        color: white !important;
        border-color: #0a53be #0a53be #fff !important;
    }
</style>
<div class="scroll-wrapper  ">
        <div class="scroll-inner">
            <div class="mb-3 rounded-3 bg-white" >
                <ul class="nav flex-column nav-tabs ">
                    <li class="nav-item  m-1">
                        <a style="font-size: 1.1rem;" class="rounded-pill text-dark nav-link {{ request()->routeIs('specialCategories.show') && request()->route('slug') === 'popular' ? 'active' : '' }}"
                           href="{{ route('specialCategories.show','popular') }}">
                            <i class="bi bi-fire" style="width: 20px; height: 20px"></i>
                            <span class="ms-1">Популярное</span>
                        </a>
                    </li>
                    <li class="nav-item m-1">
                        <a style="font-size: 1.1rem;" class="rounded-pill text-dark nav-link {{ request()->routeIs('specialCategories.show') && request()->route('slug') === 'fresh' ? 'active' : '' }}"
                           href="{{ route('specialCategories.show','fresh') }}">
                            <i class="bi bi-newspaper" style="width: 20px; height: 20px"></i>
                            <span class="ms-1">Новое 24ч</span>
                        </a>
                    </li>

                    @auth
                        <li class="nav-item m-1">
                            <a style="font-size: 1.1rem;" class="rounded-pill text-dark nav-link {{ request()->routeIs('specialCategories.show') && request()->route('slug') === 'myFeed' ? 'active' : '' }}"
                               href="{{ route('specialCategories.show','myFeed') }}">
                                <i class="bi bi-clipboard" style="width: 20px; height: 20px"></i>
                                <span class="ms-1">Моя лента</span>
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <div class="rounded-3 bg-white p-2">
                <h1 class="fs-6  ms-3" style="color: grey;">Темы</h1>
                <ul class="nav flex-column nav-tabs">
                    @if (count($categories) > 0)
                        @foreach ($categories as $category)
                            <li class="nav-item">
                                <a href="{{ route('categories.show', $category) }}"
                                   class="rounded-pill p-2 category-link d-flex align-items-center text-decoration-none text-dark w-100 h-100 nav-link {{ request()->routeIs('categories.show') && request()->route('category')->slug === $category->slug? 'active' : '' }}"
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
    </div>

{{-- END CATEGORIES --}}
