@extends('layouts.app')

@section('content')

<div class="container mt-5">

<h2>Events</h2>

<a href="{{ route('events.create') }}" class="btn btn-primary mb-3">
Create Event
</a>

@if(session('success'))

<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Title</th>
<th>Start</th>
<th>End</th>
<th>Action</th>
</tr>

@forelse($events as $event)

<tr>

<td>{{ $event->id }}</td>

<td>{{ $event->title }}</td>

<td>{{ $event->start_time }}</td>

<td>{{ $event->end_time }}</td>

<td>

<a href="{{ route('events.show',$event->id) }}"
class="btn btn-info btn-sm">
View </a>

<a href="{{ route('events.edit',$event->id) }}"
class="btn btn-warning btn-sm">
Edit </a>

<form action="{{ route('events.destroy',$event->id) }}"
method="POST"
style="display:inline-block">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="5" class="text-center">
No events found
</td>
</tr>

@endforelse

</table>

</div>

@endsection
