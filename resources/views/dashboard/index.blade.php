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

            <div class="d-flex flex-wrap gap-2 mt-2">

                <a href="{{ route('events.create') }}" class="btn btn-primary">
                    Create Event
                </a>

                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    View Events
                </a>

                <a href="#" class="btn btn-info">
                    Analytics
                </a>

                {{-- Owner Only Button --}}
                @if(auth()->user()->role == 'owner')
                    <a href="{{ route('staff.index') }}" class="btn btn-success">
                        Manage Staff
                    </a>
                @endif

            </div>

            <hr>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">
                    Logout
                </button>
            </form>

        </div>
    </div>


    {{-- Statistics Cards --}}
    <div class="row mt-4">

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total Events</h5>
                <h3>{{ $totalEvents }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Total Attendees</h5>
                <h3>{{ $totalAttendees }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Attendance Rate</h5>
                <h3>{{ $attendanceRate }}%</h3>
            </div>
        </div>

    </div>

    {{-- Owner: Add button to view attendees per event --}}
    @if(auth()->user()->role == 'owner' && isset($dashboardData->events))
        <hr class="mt-4">
        <h5>Events</h5>

        @foreach($dashboardData->events as $event)
            <div class="card shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $event->title ?? $event->name }}</strong>
                        @if(isset($event->start_time))
                            ({{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }})
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('events.attendees', $event->id) }}" class="btn btn-info btn-sm">
                            View Attendees
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>

{{-- Prevent back after logout --}}
<script>
history.pushState(null, null, location.href);
window.onpopstate = function () {
    history.go(1);
};
</script>

@endsection