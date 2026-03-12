@extends('layouts.app')

@section('content')

<div class="container mt-5">

<h2 class="mb-4">Events</h2>

<div class="row">

@foreach($events as $event)

<div class="col-md-4 mb-4">

<div class="card shadow">

<div class="card-body">

<h5>{{ $event->title }}</h5>

<p>{{ $event->description }}</p>

<p>
<strong>Start:</strong> {{ $event->start_time }}
</p>

<a href="#" class="btn btn-success">
Book Ticket
</a>

</div>

</div>

</div>

@endforeach

</div>

</div>

@endsection