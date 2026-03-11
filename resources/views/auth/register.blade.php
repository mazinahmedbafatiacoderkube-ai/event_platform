@extends('layouts.app')

@section('content')

<div class="container mt-5">

@if(session('success'))

<div class="text-center">

<h2 class="text-success">Organization Registered Successfully 🎉</h2>

<p>Your organization account has been created.</p>

<a href="{{ route('login') }}" class="btn btn-primary mt-3">
Go To Login
</a>

</div>

@else

<h2>Create Organization</h2>

@if ($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('register') }}">
@csrf

<div class="mb-3">
<label>Organization Name</label>
<input type="text" name="organization_name" class="form-control" value="{{ old('organization_name') }}" required>
</div>

<div class="mb-3">
<label>Plan</label>
<select name="plan" class="form-control">
<option value="free" {{ old('plan') == 'free' ? 'selected' : '' }}>Free</option>
<option value="pro" {{ old('plan') == 'pro' ? 'selected' : '' }}>Pro</option>
</select>
</div>

<div class="mb-3">
<label>Owner Name</label>
<input type="text" name="owner_name" class="form-control" value="{{ old('owner_name') }}" required>
</div>

<div class="mb-3">
<label>Owner Email</label>
<input type="email" name="owner_email" class="form-control" value="{{ old('owner_email') }}" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Confirm Password</label>
<input type="password" name="password_confirmation" class="form-control" required>
</div>

<button type="submit" class="btn btn-success">
Register Organization
</button>

</form>

@endif

</div>

@endsection