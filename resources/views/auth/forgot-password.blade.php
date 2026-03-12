@extends('layouts.app')

@section('content')

<div class="container mt-5">

<h2>Forgot Password</h2>

{{-- Success Message --}}
@if(session('status'))
<div class="alert alert-success">
{{ session('status') }}
</div>
@endif

{{-- Error Messages --}}
@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="mb-3">
<label>Email Address</label>
<input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
</div>

<button type="submit" class="btn btn-warning">
Send Reset Link
</button>

<a href="{{ route('login') }}" class="btn btn-primary">
Back To Login
</a>

</form>

</div>

@endsection