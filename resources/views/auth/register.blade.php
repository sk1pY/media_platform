@extends('layouts.app')
@section('content')

    <h1>Register</h1>
    <form action="{{ route('register') }}" method="POST" >
        @csrf
        <div>
            <label for="name">Name:</label>
            <input class="form-control" type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">Password:</label>
            <input class="form-control" type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirm Password:</label>
            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button class="btn btn-secondary my-2" type="submit">Register</button>
    </form>


@endsection
