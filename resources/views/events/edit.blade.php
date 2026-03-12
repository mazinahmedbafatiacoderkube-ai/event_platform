@extends('layouts.app')
 
@section('content')
 
<div class="container mt-5">
 
<h2>Edit Event</h2>
 
<form method="POST" action="{{ route('events.update',$event->id) }}">
 
@csrf
@method('PUT')
 
<div class="mb-3">
<label>Title</label>
<input type="text" name="title" value="{{ $event->title }}" class="form-control">
</div>
 
<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control">{{ $event->description }}</textarea>
</div>
 
<div class="mb-3">
<label>Start Time</label>
<input type="datetime-local" name="start_time" value="{{ $event->start_time }}" class="form-control">
</div>
 
<div class="mb-3">
<label>End Time</label>
<input type="datetime-local" name="end_time" value="{{ $event->end_time }}" class="form-control">
</div>
 
<button class="btn btn-primary">Update Event</button>
 
<a href="{{ route('events.index') }}" class="btn btn-secondary">
Cancel
</a>
 
</form>
 
</div>
 
@endsection
 