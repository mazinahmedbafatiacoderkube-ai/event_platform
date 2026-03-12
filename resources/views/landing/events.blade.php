@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <h2 class="mb-4">Events</h2>

        <a href="{{ route('landing') }}" class="btn btn-secondary mb-4">
            ← Back to Organizations
        </a>

        <div class="row">

            @forelse($events as $event)

                <div class="col-md-4 mb-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h5 class="card-title">
                                {{ $event->title }}
                            </h5>

                            <p class="text-muted">
                                {{ $event->date }}
                            </p>

                            <p>
                                {{ $event->description }}
                            </p>

                            <p>
                                <strong>Location:</strong> {{ $event->location }}
                            </p>

                            <a href="/book-ticket/{{ $event->id }}" class="btn btn-primary">
                                Book Ticket
                            </a>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-12">
                    <div class="alert alert-info">
                        No events created by this organization yet.
                    </div>
                </div>

            @endforelse

        </div>

    </div>

@endsection