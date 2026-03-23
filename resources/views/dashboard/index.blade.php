@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <div class="card shadow-sm">
            <div class="card-body">

                <h2 class="mb-3">Dashboard</h2>
                <hr>

                <h5>Welcome, {{ auth()->user()->name }} 👋</h5>
                <p class="text-muted">You are logged in successfully.</p>

                <div class="mt-4">
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                    <p><strong>Role:</strong> {{ auth()->user()->role }}</p>
                    <p><strong>Organization ID:</strong> {{ auth()->user()->organization_id }}</p>
                </div>

                <hr>

                <h5>Quick Actions</h5>

                <div class="d-flex flex-wrap gap-2 mt-2">

                    <a href="{{ route('events.create') }}" class="btn btn-primary">
                        Create Event
                    </a>

                    <a href="{{ route('events.index') }}" class="btn btn-secondary">
                        View Events
                    </a>

                    @if(auth()->user()->role == 'owner')
                        <a href="{{ route('staff.index') }}" class="btn btn-success">
                            Manage Staff
                        </a>
                    @endif

                </div>

                <hr>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Logout
                    </button>
                </form>

            </div>
        </div>

        {{-- Analytics Section --}}
        <hr class="mt-4">
        <h4 class="mb-3">Analytics</h4>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Total Events</h5>
                    <h3>{{ $totalEvents }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Total Attendees</h5>
                    <h3>{{ $totalAttendees }}</h3>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm p-3">
                    <h5>Attendance Rate</h5>
                    <h3>{{ $attendanceRate }}%</h3>
                </div>
            </div>
        </div>

        {{-- Owner Events Section --}}
        @if(auth()->user()->role == 'owner' && isset($dashboardData->events))
            <hr class="mt-4">
            <h5>Events</h5>

            @foreach($dashboardData->events as $event)
                <div class="card shadow-sm mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $event->title ?? $event->name }}</strong>
                            @if(isset($event->start_time))
                                ({{ \Carbon\Carbon::parse($event->start_time)->format('d M Y') }})
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('events.attendees', $event->id) }}" class="btn btn-info btn-sm">
                                View Attendees
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Event-Specific Chat --}}
        <hr class="mt-4">
        <h4>💬 Event Chat</h4>

        <select id="event-select" class="form-control mb-2">
            <option value="">Select Event</option>
            @if(isset($dashboardData->events))
                @foreach($dashboardData->events as $event)
                    <option value="{{ $event->id }}">{{ $event->title }}</option>
                @endforeach
            @endif
        </select>

        <div id="chat-box" style="height:250px; overflow-y:auto; border:1px solid #ccc; padding:10px; background:#f9f9f9;">
        </div>

        <div class="d-flex mt-2">
            <input type="text" id="message-input" class="form-control" placeholder="Type your message...">
            <button onclick="sendMessage()" class="btn btn-primary ms-2">Send</button>
        </div>

    </div>

    {{-- Prevent back after logout --}}
    <script>
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>

@endsection

@section('scripts')
    <script>
        // Single currentUserId declaration
        const currentUserId = {!! auth()->id() ?? 0 !!};

        function renderMessage(msg) {
            console.log("FULL MSG:", msg);

            const senderId = msg.user_id ?? null;
            const isMine = Number(senderId) === Number(currentUserId);

            return `
                <div style="display:flex; justify-content:${isMine ? 'flex-end' : 'flex-start'}">
                    <div style="background:${isMine ? 'blue' : 'gray'}; color:white; padding:10px; margin:5px; max-width:80%;">
                        ${msg.message}
                    </div>
                </div>
            `;
        }

        let eventId = null;
        const chatBox = document.getElementById('chat-box');

        document.getElementById('event-select').addEventListener('change', function () {

            eventId = this.value;
            chatBox.innerHTML = '';

            if (!eventId) return;

            // Load previous messages
            fetch(`/events/${eventId}/messages`)
                .then(res => res.json())
                .then(data => {
                    data.reverse().forEach(msg => {
                        chatBox.innerHTML += renderMessage(msg);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                });

            // Leave any previous channels to avoid duplicates
            window.Echo.leaveAllChannels();

            // Listen for new messages
            window.Echo.channel(`event.${eventId}`)
                .listen('MessageSent', (e) => {
                    console.log("EVENT DATA:", e.message);
                    chatBox.innerHTML += renderMessage(e.message);
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        });

        function sendMessage() {
            const input = document.getElementById('message-input');
            if (!eventId || input.value.trim() === '') return;

            fetch(`/events/${eventId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: input.value })
            });

            input.value = '';
        }
    </script>
@endsection