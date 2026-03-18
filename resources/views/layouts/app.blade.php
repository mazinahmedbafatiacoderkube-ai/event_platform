<!DOCTYPE html>
<html>

<head>

<title>Event Collaboration Platform</title>
<meta http-equiv="Cache-Control" content="no-store" />

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

<div class="container">

@php
    $attendee = auth('attendee')->user();
@endphp

<a class="navbar-brand" href="{{ $attendee ? route('landing') : url('/dashboard') }}">
    Event Platform
</a>
<div class="d-flex align-items-center">

@auth

@php
    $attendee = auth('attendee')->user();
@endphp

{{-- 🔔 SHOW ONLY IF NOT ATTENDEE --}}
@if(!$attendee)
<div class="dropdown">

<button class="btn btn-dark position-relative dropdown-toggle" type="button" data-bs-toggle="dropdown">

🔔

@if(auth()->user()->unreadNotifications->count() > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        {{ auth()->user()->unreadNotifications->count() }}
    </span>
@endif

</button>

<ul class="dropdown-menu dropdown-menu-end" style="width:300px; max-height:300px; overflow-y:auto;">

@if(auth()->user()->notifications->count() == 0)

<li class="dropdown-item text-center text-muted">
No notifications
</li>

@else

@foreach(auth()->user()->unreadNotifications->take(5) as $notification)

<li>

<a href="{{ route('notifications.open',$notification->id) }}" class="dropdown-item">

<div>
<strong>{{ $notification->data['title'] ?? 'Event Notification' }}</strong>
</div>

<div class="small text-muted">
{{ $notification->data['message'] ?? '' }}
</div>

<div class="small text-muted">
{{ $notification->created_at->diffForHumans() }}
</div>

</a>

</li>

@endforeach

<hr class="dropdown-divider">

<li class="dropdown-item text-center">

<form action="{{ route('notifications.markAll') }}" method="POST">
@csrf
<button class="btn btn-sm text-dark border-0 bg-transparent">
Mark all as read
</button>
</form>

</li>

@endif

</ul>

</div>
@endif

<span class="text-white ms-3">
{{ $attendee ? $attendee->name : auth()->user()->name }}
</span>

@endauth

</div>

</div>

</nav>


<div class="container mt-4">

@yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>