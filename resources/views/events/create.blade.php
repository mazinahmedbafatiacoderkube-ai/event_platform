@extends('layouts.app')

@section('content')

<h2>Create Event</h2>

<form>

<div class="mb-3">
<label>Title</label>
<input class="form-control">
</div>

<div class="mb-3">
<label>Description</label>
<textarea class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Start Time</label>
<input type="datetime-local" class="form-control">
</div>

<div class="mb-3">
<label>End Time</label>
<input type="datetime-local" class="form-control">
</div>

<button class="btn btn-success">Create</button>

</form>

@endsection