@extends('layouts.app')

@section('content')

<h2>Dashboard</h2>

<div class="card p-4">

<h4>Welcome, {{ auth()->user()->name }} 👋</h4>

<p>You are logged in successfully.</p>

<p><strong>Email:</strong> {{ auth()->user()->email }}</p>

<p><strong>Role:</strong> {{ auth()->user()->role }}</p>

<p><strong>Organization ID:</strong> {{ auth()->user()->organization_id }}</p>

<hr>

<h5>Quick Actions</h5>

<a href="/events" class="btn btn-primary">Events</a>
<a href="/attendees" class="btn btn-secondary">Attendees</a>
<a href="/chat" class="btn btn-info">Chat</a>
<a href="/analytics" class="btn btn-warning">Analytics</a>

<hr>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="btn btn-danger">Logout</button>
</form>

</div>

@endsection
