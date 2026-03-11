@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-3">Dashboard</h2>
            <hr>

            <h5>Welcome, {{ auth()->user()->name }} 👋</h5>
            <p class="text-muted">You are logged in successfully.</p>

            <div class="mt-4">
                <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
                <p><strong>Organization ID:</strong> {{ auth()->user()->organization_id }}</p>
            </div>

            <hr>
            <h5>Quick Actions</h5>
            <div class="d-flex gap-2 mt-2">
                <a href="#" class="btn btn-primary">Create Event</a>
                <a href="#" class="btn btn-secondary">View Events</a>
                <a href="#" class="btn btn-info">Analytics</a>
            </div>

            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Events</h5>
                <h3>{{ $totalEvents }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Total Attendees</h5>
                <h3>{{ $totalAttendees }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3">
                <h5>Attendance Rate</h5>
                <h3>{{ $attendanceRate }}%</h3>
            </div>
        </div>
    </div>
</div>
@endsection
