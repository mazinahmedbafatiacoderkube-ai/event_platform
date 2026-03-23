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
        const currentUserId = {!! auth()->id() ? auth()->id() : 'null' !!};
        function renderMessage(msg) {
            const senderId = msg.sender_id;
            const senderType = msg.sender_type;
            const senderName = msg.sender_name;

            const myId = currentUserId ? Number(currentUserId) : null;
            const myType = currentUserId ? 'user' : 'attendee';

            const isMine =
                senderId &&
                myId &&
                Number(senderId) === myId &&
                senderType === myType;

            return `
            <div style="display:flex; margin-bottom:8px; justify-content:${isMine ? 'flex-end' : 'flex-start'}">
                <div style="
                    padding:8px 12px;
                    border-radius:12px;
                    max-width:60%;
                    background:${isMine ? '#007bff' : '#e4e6eb'};
                    color:${isMine ? '#fff' : '#000'};
                ">
                    <div style="font-size:12px; font-weight:bold;">
                        ${senderName}
                    </div>
                    <div>${msg.message}</div>
                </div>
            </div>
        `;
        }

        const events = @json($events);

        events.forEach(event => {

            let chatBox = document.getElementById(`chat-box-${event.id}`);

            fetch(`/events/${event.id}/messages`)
                .then(res => res.json())
                .then(data => {
                    data.reverse().forEach(msg => {
                        chatBox.innerHTML += renderMessage(msg);
                    });
                    chatBox.scrollTop = chatBox.scrollHeight;
                });

            window.Echo.channel(`event.${event.id}`)
                .listen('MessageSent', (e) => {
                    chatBox.innerHTML += renderMessage(e.message);
                    chatBox.scrollTop = chatBox.scrollHeight;
                });
        });

        function sendMessage(eventId) {
            let input = document.getElementById(`input-${eventId}`);
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