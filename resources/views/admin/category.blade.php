@extends('admin.layouts.index')
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
    <form action="{{route('admin.categories.store')}}" method="post" class="d-flex g-2 m-2 w-50" enctype="multipart/form-data">
        @csrf
        <div class="d-flex flex-column m-3">
            <label for="name">Категория</label>
            <input id="name" class="form-control" type="text" name="name">
            <label for="image">Фото</label>

            <input id="image" class="form-control " type="file" name="image">
            <input class="btn btn-sm btn-secondary mt-2" type="submit" value="Добавить">

        </div>

    </form>
    <table id="table" class="table table-sm table-bordered table-striped small">
        <thead>
        <tr class="align-middle">
            <th scope="col" class="col-8 text-center">имя</th>
            <th scope="col" class="col-8 text-center">дата </th>
            <th scope="col" class="col-3 text-center">Изменить/Удалить</th>
        </tr>
        </thead>
        <tbody class="tablecontents">
        @foreach( $categories as $category )
            <tr class="align-middle ">
                <td class="ps-3 "><a href="{{ route('categories.show',['category' => $category->id]) }}"
                                class="text-decoration-none text-dark ">{{$category -> name}}</a>
                </td>
                <td>
                    {{$category->created_at}}
                </td>
                <td class="d-flex justify-content-center">
                    <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $category->id }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}" method="post" class="ms-2">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm text-danger">
                            <i class="bi bi-x"></i>
                        </button>
                    </form>
                    {{--                    MODAL--}}
                    <div class="modal fade" id="modal-{{$category->id}}" data-bs-backdrop="static"
                         data-bs-keyboard="false"
                         tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">информация о пользователе</h1>
                                </div>
                                <div class="modal-body">
                                    <form id="formChangeTitle-{{$category->id}}"
                                          action="{{ route('admin.categories.update',['category'=>$category->id]) }}"
                                          method="post"
                                          enctype="multipart/form-data"
                                    >
                                        @csrf
                                        @method('patch')
                                        <input class="form-control" type="text" name="name" value="{{$category->name}}">
                                        <input type="file" name="image">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button form="formChangeTitle-{{$category->id}}" type="submit"
                                            class="btn btn-success">Принять
                                    </button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>

            </tr>
            <div class="mt-4">
            </div>

        @endforeach
        </tbody>
    </table>
    {{ $categories->links('pagination::bootstrap-5') }}
 <script src="{{asset('js/table.js')}}"></script>

@endsection


