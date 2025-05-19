{{--        FILTER --}}
<div class="m-2">
    <form  id="filterForm" method="get">

        <select class="form-select w-25 text-decoration-none" id="rating" name="filter" form="filterForm"
                onchange="this.form.submit()">
            <option value="">Выберите фильтр</option>
            <option value="recent" {{ request('filter') === 'recent' ? 'selected' : '' }}>Самые новые
            </option>
            <option value="old" {{ request('filter') === 'old' ? 'selected' : '' }}> Самые старые
            </option>
            <option value="popular" {{ request('filter') === 'popular' ? 'selected' : '' }}>Популярные
            </option>
        </select>
    </form>
</div>
{{--        FILTER --}}
