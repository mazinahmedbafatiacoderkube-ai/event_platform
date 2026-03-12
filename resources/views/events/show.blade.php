@extends('layouts.app')

@section('content')

<div class="container mt-5">

<div class="card shadow-sm">

<div class="card-header bg-primary text-white">
<h4 class="mb-0">Event Details</h4>
</div>

<div class="card-body">

<div class="row mb-3">
<div class="col-md-3"><strong>Title</strong></div>
<div class="col-md-9">{{ $event->title }}</div>
</div>

<div class="row mb-3">
<div class="col-md-3"><strong>Description</strong></div>
<div class="col-md-9">{{ $event->description }}</div>
</div>

<div class="row mb-3">
<div class="col-md-3"><strong>Start Time</strong></div>
<div class="col-md-9">{{ $event->start_time }}</div>
</div>

<div class="row mb-3">
<div class="col-md-3"><strong>End Time</strong></div>
<div class="col-md-9">{{ $event->end_time }}</div>
</div>

<div class="row mb-3">
<div class="col-md-3"><strong>Status</strong></div>
<div class="col-md-9">
<span class="badge bg-success">
{{ $event->status ?? 'Active' }}
</span>
</div>
</div>

{{-- Only OWNER can see creator --}}
@if(auth()->user()->role === 'owner')

<div class="row mb-3">
<div class="col-md-3"><strong>Created By</strong></div>
<div class="col-md-9">
{{ $event->creator->name ?? 'N/A' }}
</div>
</div>

@endif

<hr>

<div class="d-flex gap-2">

{{-- Edit button based on policy --}}
@can('update', $event)

<a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">
Edit
</a>

@endcan


{{-- Delete button based on policy --}}
@can('delete', $event)

<form action="{{ route('events.destroy', $event->id) }}" method="POST">
@csrf
@method('DELETE')

<button class="btn btn-danger"
onclick="return confirm('Are you sure you want to delete this event?')">
Delete
</button>

</form>

@endcan

<a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
Back
</a>

</div>

</div>

</div>

</div>

@endsection