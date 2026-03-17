@extends('layouts.app')

@section('content')

<div class="container mt-5" style="max-width:500px;">

    <div class="card shadow">
        <div class="card-body">

            <h3 class="text-center mb-4">Attendee Registration</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('attendees.register.submit') }}">
                @csrf

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-success">
                        Register
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}">
                        Already have an account? Login
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection