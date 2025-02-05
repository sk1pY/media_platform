@extends('layouts.app')
@section('content')

<div class="vh-100 d-flex justify-content-center align-items-center">
    <form method="POST" action="{{ route('register') }}" class="p-4 bg-white rounded shadow-sm w-100" style="max-width: 400px;">
        @csrf
        <h2 class="mb-4 text-center">Регистрация</h2>

        <div class="mb-3">
            <label for="name" class="form-label">Имя</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Почта</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
    
@endsection
