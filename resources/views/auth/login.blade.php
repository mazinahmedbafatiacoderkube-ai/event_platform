@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <h2>Login</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">
                Login
            </button>



            <a href="{{ route('register') }}" class="btn btn-secondary">
                Register
            </a>
            <a href="{{ route('password.request') }}">
                Forgot Password?
            </a>
            
    </div>


    </form>

    </div>

@endsection