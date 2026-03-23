@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <h2 class="mb-4">Events</h2>

        <a href="{{ route('landing') }}" class="btn btn-secondary mb-4">
            ← Back to Organizations
        </a>

        <div class="row">

            @forelse($events as $event)

                <div class="col-md-6 mb-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h5>{{ $event->title }}</h5>

                            <p class="text-muted">
                                Start: {{ $event->start_Time }} <br>
                                End: {{ $event->end_Time }}
                            </p>

                            <p>{{ $event->description }}</p>

                            <a href="{{ route('book.ticket.page', $event->id) }}" class="btn btn-primary mb-2">
                                Book Ticket
                            </a>

                            <hr>

                            <!-- 🔥 CHAT SECTION -->
                            <h6>💬 Chat</h6>

                            <div id="chat-box-{{ $event->id }}"
                                style="height:150px; overflow-y:auto; border:1px solid #ccc; padding:5px;">
                            </div>

                            <div class="d-flex mt-2">
                                <input type="text" id="input-{{ $event->id }}" class="form-control"
                                    placeholder="Type a message...">
                                <button onclick="sendMessage({{ $event->id }})" class="btn btn-sm btn-primary ms-2">
                                    Send
                                </button>
                            </div>

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

@section('scripts')
    <script>
        // Keep single currentUserId
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

        const events = @json($events);

        events.forEach(event => {

            const chatBox = document.getElementById(`chat-box-${event.id}`);

            // Load existing messages
            fetch(`/events/${event.id}/messages`)
                .then(res => res.json())
                .then(data => {
                    data.reverse().forEach(msg => {
                        chatBox.innerHTML += renderMessage(msg);
                        chatBox.scrollTop = chatBox.scrollHeight; // scroll after each message
                    });
                });

            // Listen for new messages in real-time
            window.Echo.channel(`event.${event.id}`)
                .listen('MessageSent', (e) => {
                    console.log("EVENT DATA:", e.message);
                    chatBox.innerHTML += renderMessage(e.message);
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        });

        function sendMessage(eventId) {
            const input = document.getElementById(`input-${eventId}`);
            if (!input.value.trim()) return;

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