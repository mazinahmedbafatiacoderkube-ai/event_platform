<!DOCTYPE html>
<html>

<head>

<title>Event Platform</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

.hero{
background:#4f46e5;
color:white;
padding:60px;
}

.org-card{
transition:0.3s;
}

.org-card:hover{
transform:scale(1.05);
}

</style>

</head>

<body>

<nav class="navbar navbar-dark bg-dark">

<div class="container">

<a class="navbar-brand">Event Platform</a>

<div>

<a href="{{ route('login') }}" class="btn btn-light">
Login
</a>

</div>

</div>

</nav>


<div class="hero text-center">

<h1>Discover Events</h1>

<p>Choose an organization to view events</p>

</div>


<div class="container mt-5">

<div class="row">

@foreach($organizations as $org)

<div class="col-md-4 mb-4">

<div class="card org-card shadow">

<div class="card-body text-center">

<h5>{{ $org->name }}</h5>

<p class="text-muted">
{{ $org->description ?? 'Organization events' }}
</p>

<a href="{{ route('organization.events',$org->id) }}"
class="btn btn-primary">

View Events

</a>

</div>

</div>

</div>

@endforeach

</div>

</div>

</body>

</html>