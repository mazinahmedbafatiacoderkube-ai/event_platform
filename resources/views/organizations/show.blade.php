@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <!-- Organization Name -->
    <h2>{{ $organization->name }}</h2>
    <p>Plan: {{ $organization->plan ?? 'N/A' }}</p>

    <!-- Events List -->
    <h4 class="mt-4">Active Events</h4>

    @if($organization->events->isEmpty())
        <p>No active events for this organization.</p>
    @else
        <ul class="list-group">
            @foreach($organization->events as $event)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $event->title }}</strong><br>
                        <small>{{ \Carbon\Carbon::parse($event->start_time)->format('d M, Y H:i') }} - 
                               {{ \Carbon\Carbon::parse($event->end_time)->format('d M, Y H:i') }}</small><br>
                        <span>{{ $event->description }}</span>
                    </div>
                    <div>
                        <a href="{{ route('attendees.create', $event->id) }}" class="btn btn-success">
                            Book Ticket
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

</div>
@endsection