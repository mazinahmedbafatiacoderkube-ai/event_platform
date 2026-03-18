@extends('layouts.app')

@section('content')

<div class="container mt-5" style="max-width:500px;">

    <div class="card shadow">
        <div class="card-body">

            <h3 class="text-center mb-4">Login</h3>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

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
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>
                </div>

                <!-- 🔽 NEW DROPDOWN REGISTER BUTTON -->
                <div class="d-grid mb-3">
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle w-100"
                                type="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            Register
                        </button>

                        <ul class="dropdown-menu w-100 shadow border-0">
                            <li>
                                <a class="dropdown-item py-2"
                                   href="{{ route('attendees.register') }}">
                                    👤 Register as Attendee
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2"
                                   href="{{ route('register') }}">
                                    🏢 Register as Organization
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}">
                        Forgot Password?
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>

{{-- Prevent back after logout --}}
<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>

@endsection 