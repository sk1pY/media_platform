@extends('admin.index')
@section('title', 'todo app')
@section('content_admin')


    <table class="table ">
        <thead>
        <tr>
            <th scope="col">id</th>
            <th scope="col">name</th>
        </tr>
        </thead>
        @foreach($users as $user)
        <tbody>
            <tr>
                <td>{{$user -> email}}</td>
                <td>{{$user -> name}}</td>
            </tr>
        @endforeach
    </table>

@endsection
