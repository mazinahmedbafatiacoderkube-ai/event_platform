@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Events of {{ $organization->name }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organization->events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->start_time }}</td>
                    <td>{{ $event->end_time }}</td>
                    <td>
                        <a href="{{ route('attendees.create', $event->id) }}" class="btn btn-success">Book Ticket</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection