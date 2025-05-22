@extends('admin.layouts.index')
@section('content')
    <div class="p-3">
        <h4>Пользователи</h4>
        <table id="table" class="table table-sm table-bordered table-striped mt-2 align-middle text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Имя</th>
                <th scope="col">Роль</th>
                <th scope="col">Статус</th>
                <th scope="col">#</th>
            </tr>
            </thead>
            <tbody id="tablecontents">
            @foreach( $users as $user )
                <tr>
                    <th scope="row">{{$user -> id}}</th>
                    <td><a href="{{route('users.show',$user)}}"
                           class="text-decoration-none text-dark">{{$user -> name}}</a></td>
                    <td>
                        <select
                            name="role"
                            class="role-update form-select form-select-sm"
                            data-url="{{route('admin.users.role.update',$user)}}">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{$role->name}}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td >
                        <div class="form-check form-switch ">
                            <input
                                data-id="{{$user->id}}"
                                data-url="{{route('admin.users.status.update',$user)}}"

                                class="js-switch form-check-input" type="checkbox" role="switch"
                                {{$user->status? "checked":""}}>
                        </div>
                    </td>
                    <td>
                        <form action="{{ route('admin.users.destroy',['user'=> $user->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm"
                                    onclick="return confirm('Точно удалить?')">
                                <i type="submit" class="bi bi-x"></i>
                            </button>
                        </form>

                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    </div>

@endsection
