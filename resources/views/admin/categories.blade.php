@extends('layouts.admin')
@section('admin-content')
    <div class="container-fluid px-3">
        <h5 class="mt-3">Создать категорию</h5>
        <hr>
        <form action="{{ route('admin.categories.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="row g-2 mb-4 w-50">
            @csrf
            <div class="col-12">
                <label for="name" class="form-label">Название</label>
                <input id="name" name="name" type="text" class="form-control">
            </div>

            <div class="col-12">
                <label for="image" class="form-label">Изображение</label>
                <input id="image" name="image" type="file" class="form-control">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-sm btn-primary">Добавить</button>
            </div>
        </form>
        <hr>
        <h5 class="mb-3">Категории</h5>
        <hr>
        <table class="table table-sm table-bordered table-striped align-middle small">
            <thead class="table-light text-center">
            <tr>
                <th>Название</th>
                <th>Создано</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>
                        <a href="{{ route('categories.show', $category) }}"
                           class="text-decoration-none text-dark">
                            {{ $category->name }}
                        </a>
                    </td>

                    <td class="text-center">{{ $category->created_at->format('d.m.Y H:i') }}</td>

                    <td class="text-center">
                        <button class="btn btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modal-{{ $category->id }}">
                            <i type="submit" class="bi bi-pencil-square"></i>
                        </button>

                        <form action="{{ route('admin.categories.destroy', $category) }}"
                              method="POST"
                              class="d-inline ms-1">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm"
                                    onclick="return confirm('Точно удалить?')">
                                <i type="submit" class="bi bi-x"></i>
                            </button>
                        </form>
                        {{--                MODAL--}}
                        <div class="modal fade" id="modal-{{ $category->id }}"
                             tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form id="form-{{ $category->id }}"
                                          action="{{ route('admin.categories.update', $category) }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Редактировать категорию</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label class="form-label">Название</label>
                                            <input type="text" name="name" value="{{ $category->name }}"
                                                   class="form-control mb-2">
                                            <label class="form-label">Изображение</label>
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success btn-sm">Сохранить</button>
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Отмена
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
