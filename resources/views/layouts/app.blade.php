
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

<a class="navbar-brand" href="/dashboard">Event Platform</a>

<div>
{{-- 
<a class="nav-link text-white d-inline" href="/">Events</a>

{{-- <a class="nav-link text-white d-inline" href="/attendees">Attendees</a>

<a class="nav-link text-white d-inline" href="/chat">Chat</a>

<a class="nav-link text-white d-inline" href="/analytics">Analytics</a> --}}

{{-- </div> --}} --}}

</div>

</nav>

<div class="container mt-4">

@yield('content')

</div>

</body>

</html>
{{-- <script>
    // Prevent back navigation
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
    };
</script> --}}
