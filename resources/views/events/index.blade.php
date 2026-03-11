@extends('layouts.app')

@section('content')

<h2>Events</h2>

<a href="/events/create" class="btn btn-primary mb-3">Create Event</a>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Title</th>
<th>Status</th>
<th>Action</th>
</tr>

</table>

@endsection