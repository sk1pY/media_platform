@extends('admin.layouts.index')
@section('content')
    @if ( session('success') )
        <div class="alert alert-success d-flex px-4">
            <div>{{ session('success') }}</div>
        </div>
    @endif
    <div class="row m-3">
        <div class="col-5 ">
            <form action="{{ route('admin.roles.store') }}" method="post" class="d-flex align-items-center gap-2 ">
                @csrf
                <input type="text" placeholder="роль" name="name">
                <input class="btn btn-sm btn-primary" type="submit" value="Добавить">
            </form>
            <h1>Роли</h1>
            <table class="table table-sm table-bordered table-striped small">
                <thead>
                <tr>
                    <th scope="col" class="col-1">#</th>
                    <th scope="col" class="col-7">Автор</th>
                    <th scope="col" class="col-1">Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <th scope="row">{{$role -> id}}</th>
                        <td>
                        {{$role->name}}
                        <td>
                            <form action="{{ route('admin.roles.destroy',$role) }}" method="post">
                                @csrf
                                @method('delete')
                                <input class="btn btn-sm btn-danger" type="submit" value="Удалить">
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-5 ">
            <form action="{{ route('admin.permissions.store') }}" method="post" class="d-flex align-items-center gap-2">
                @csrf
                <input class="form-control" type="text" placeholder="Разрешение" name="name">
                <input class="btn btn-sm btn-primary" type="submit" value="Добавить">
            </form>

            <h1>Разрешения</h1>
            <table class="table table-sm table-bordered table-striped small">
                <thead>
                <tr>
                    <th scope="col" class="col-1">#</th>
                    <th scope="col" class="col-7">Автор</th>
                    <th scope="col" class="col-1">Удалить</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <th scope="row">{{$permission -> id}}</th>
                        <td>
                        {{$permission->name}}
                        <td>
                            <form action="{{ route('admin.permissions.destroy', $permission) }}"
                                  method="post">
                                @csrf
                                @method('delete')
                                <input class="btn btn-sm btn-danger" type="submit" value="Удалить">
                            </form>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
    <table class="table table-sm table-bordered table-striped small">
        <thead>
        <tr>
            <th scope="col" class="col-1">Роль</th>
            <th scope="col" class="col text-center">Разрешения</th>
        </tr>
        </thead>
        <tbody>
        @foreach($rolesWithPermissions as $role)
            <tr>
                <td>
                    {{$role->name}}
                </td>
                <td>
                        @foreach($permissions as $permission)
                            <div class="permission-update form-check form-check-inline"
                                 data-url ="{{route('admin.roles.permissions.update',$role)}}"
                                 data-permission-id ="{{$permission->id}}">
                                <input class="  form-check-input"

                                       type="checkbox"
                                       value="{{ $permission->id }}"
                                       @if($role->permissions->contains($permission)) checked @endif>
                                <label class="form-check-label" for="inlineCheckbox1">{{$permission->name}}</label>
                            </div>
                        @endforeach
                </td>

            </tr>
            @endforeach
        </tbody>

    </table>
@endsection
