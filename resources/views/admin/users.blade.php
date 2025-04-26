@extends('admin.layouts.index')
@section('content')

    <table id="table" class="table table-sm table-bordered table-striped ">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Роль</th>
            <th scope="col">#</th>
            <th scope="col">#</th>
        </tr>
        </thead>
        <tbody id="tablecontents">
        @foreach( $users as $user )
            <tr>
                <th scope="row">{{$user -> id}}</th>
                <td>{{$user -> name}}</td>
                <td>
                        <select
                            name="role"
                            class="role-update form-select form-select-sm"
                            data-url="{{route('admin.users.update.role',$user->id)}}">
                        @foreach($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{$role->name}}
                                </option>
                            @endforeach
                        </select>
                </td>
                <td class="">
                    <div class="form-check form-switch ">
                        <input
                            data-id="{{$user->id}}"
                            data-url="{{route('admin.users.update.status',$user->id)}}"

                            class="js-switch form-check-input" type="checkbox" role="switch"
                            {{$user->status? "checked":""}}>
                    </div>
                </td>
                <td>
                    <form action="{{ route('admin.users.destroy',['user'=> $user->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-sm btn-danger" type="submit">удалить</button>
                    </form>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $users->links('pagination::bootstrap-5') }}
    </div>


@endsection
