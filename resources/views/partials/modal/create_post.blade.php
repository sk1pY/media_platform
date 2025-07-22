{{-- MODAL CREATE POST--}}
<div class="modal fade" id="createPost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Новый пост</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.posts.store') }}" enctype="multipart/form-data" method="POST" class="needs-validation" novalidate >
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Название</label>
                        <input name="title" type="text" class="form-control" id="title"
                               placeholder="Заголовок" value="{{old('title')}}" required>

                    </div>
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Короткое описание</label>
                        <input name="short_description" type="text" class="form-control" id="short_description"
                               placeholder="Описание" value="{{old('short_description')}}" required>

                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <input id="description" type="hidden" name="description" value="{{ old('description') }}" required>
                        <trix-editor style="height: 200px" class="trix-content" input="description"></trix-editor>

                    </div>

                    <div class="mb-3">
                        Выберите категорию
                        @if (count($categories) > 0)
                            <select name="category_id" class="form-select">
                                <option value="" selected>Без категории</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput2" class="form-label">Фото поста</label>
                        <input name="image" type="file" class="form-control" id="exampleFormControlInput2">
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <input type="submit" value="Создать" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
{{-- END MODAL CREATE POST--}}
