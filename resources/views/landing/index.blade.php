@extends('layouts.app')

@section('content')

<style>
    .hero {
        background: #4f46e5;
        color: white;
        padding: 30px 20px;
        text-align: center;
        border-radius: 8px;
    }

    .org-card {
        transition: 0.3s;
    }

    .org-card:hover {
        transform: scale(1.05);
    }

    .attendee-info, .tickets-info {
        background: #f3f4f6;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
    }
</style>

<!-- Hero / Attendee Info -->
<div class="hero mb-5">
    <h1>Welcome, {{ auth('attendee')->user()->name }}!</h1>
    <p>Your dashboard overview</p>
</div>

<div class="container">
    <!-- Attendee Details -->
    <div class="attendee-info shadow-sm mb-5">
        <h4>Profile Info</h4>
        <p><strong>Name:</strong> {{ auth('attendee')->user()->name }}</p>
        <p><strong>Email:</strong> {{ auth('attendee')->user()->email }}</p>
        <form action="{{ route('attendees.logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- Your Booked Tickets -->
    <div class="tickets-info shadow-sm mb-5">
        <h4>Your Booked Tickets</h4>
        @if($bookedTickets->count() > 0)
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Email</th>
                        <th>Ticket Type</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookedTickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->email }}</td>
                            <td>{{ $ticket->ticket_type }}</td>
                            <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-muted mt-2">You have not booked any tickets yet.</p>
        @endif
    </div>

    <!-- Upcoming Events -->
    
    @foreach($events as $event)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5>{{ $event->title }}</h5>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }}</p>

                @php
                    $announcementChannel = $event->channels->where('type', 'announcements')->first();
                @endphp

                @if($announcementChannel && $announcementChannel->messages->count() > 0)
                    <div class="alert alert-info mt-2">
                        <h6>Announcements:</h6>
                        @foreach($announcementChannel->messages as $msg)
                            <p>
                                <strong>{{ $msg->user->name }}:</strong>
                                {{ $msg->message }}
                            </p>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mt-2">No announcements yet.</p>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Organizations -->
    <h2 class="mt-5">Organizations</h2>
    <hr>
    <div class="row">
        @foreach($organizations as $org)
            <div class="col-md-4 mb-4">
                <div class="card org-card shadow">
                    <div class="card-body text-center">
                        <h5>{{ $org->name }}</h5>
                        <p class="text-muted">{{ $org->description ?? 'Organization events' }}</p>
                        <a href="{{ route('organization.events', $org->id) }}" class="btn btn-primary">
                            View Events
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection