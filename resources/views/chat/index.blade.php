@extends('layouts.app')

@section('content')

<h3>{{ $channel->name }}</h3>

<div class="card p-3 mb-3" style="height:400px; overflow-y:scroll;">

@foreach($messages as $msg)

<p>
<strong>{{ $msg->user->name }}</strong> :
{{ $msg->message }}
</p>

@endforeach

</div>

<form method="POST" action="{{ route('chat.send') }}">
@csrf

<input type="hidden" name="channel_id" value="{{ $channel->id }}">

<div class="input-group">

<input type="text" name="message" class="form-control" placeholder="Type message">

<button class="btn btn-primary">Send</button>

</div>

</form>

@endsection