@extends('layouts.app')

@section('content')

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark shadow">
<div class="container">

<a class="navbar-brand fw-bold" href="/">EventSphere</a>

<a href="{{ route('book') }}" class="btn btn-light">
Home
</a>

</div>
</nav>

<!-- BOOKING CARD -->
<div class="container d-flex justify-content-center align-items-center" style="min-height:80vh;">

<div class="card shadow-lg p-4" style="width:420px;border-radius:12px;">

<h4 class="mb-4 text-center">🎟 Book Event Ticket</h4>

@if(session('success'))
<div class="alert alert-success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('ticket.book', $event) }}">
@csrf

<div class="mb-3">
<label class="form-label">Full Name</label>
<input type="text" name="name" class="form-control" placeholder="Enter your name" required>
</div>

<div class="mb-3">
<label class="form-label">Email Address</label>
<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
</div>

<div class="mb-3">
<label class="form-label">Ticket Type</label>
<select name="ticket_type" class="form-control">
<option value="regular">Regular</option>
<option value="vip">VIP</option>
</select>
</div>

<button class="btn btn-success w-100 mt-2">
Book Ticket
</button>

</form>

</div>
</div>

@endsections