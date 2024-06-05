@extends('admin.index')
@section('title', 'todo app')
@section('content_admin')
<form action="{{ route('cat.add') }}" method="post">
    @csrf
    <input type="text" name="name">
    <input type="submit">
</form>
@endsection
