@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Attendees for: {{ $event->title ?? $event->name }}</h2>
    <p>Date: {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y H:i') }}</p>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">Back to Dashboard</a>

    @if($event->attendees->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->attendees as $index => $attendee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $attendee->name }}</td>
                        <td>{{ $attendee->email }}</td>
                        <td>{{ $attendee->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">No attendees registered yet.</p>
    @endif
</div>
@endsection