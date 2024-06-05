@extends('admin.index')
@section('title', 'todo app')
@section('content_admin')

@foreach($users as $user)
    <p> {{$user -> name}} </p>
@endforeach
@endsection
