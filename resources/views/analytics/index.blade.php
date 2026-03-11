@extends('layouts.app')

@section('content')

<h2>Analytics</h2>

<div class="card p-4">

<p>Total Events: {{ $stats['total_events'] }}</p>

<p>Total Attendees: {{ $stats['total_attendees'] }}</p>

<p>Attendance Rate: {{ $stats['attendance_rate'] }}%</p>

</div>

@endsection