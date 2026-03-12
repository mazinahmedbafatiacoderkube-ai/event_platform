@extends('layouts.app')

@section('content')

<div class="container mt-5">

```
<h2>Create Event</h2>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('events.store') }}">
    @csrf

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label>Start Time</label>
        <input type="datetime-local" name="start_time" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>End Time</label>
        <input type="datetime-local" name="end_time" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">
        Create Event
    </button>

    <a href="{{ url('/') }}" class="btn btn-secondary">
        Cancel
    </a>

</form>
```

</div>

@endsection
